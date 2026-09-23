<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\User;

function createHomePageProduct(array $overrides = []): Product
{
    $category = Category::factory()->create();

    return Product::factory()->create(array_merge([
        'category_id' => $category->id,
        'sub_category_id' => SubCategory::factory()->create(['category_id' => $category->id])->id,
    ], $overrides));
}

test('home page orders trending products by hit count', function () {
    $popular = createHomePageProduct(['hit_count' => 50, 'name' => 'Popular Widget Alpha']);
    $obscure = createHomePageProduct(['hit_count' => 2, 'name' => 'Obscure Widget Beta']);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSeeInOrder([$popular->name, $obscure->name]);
});

test('home page orders best sellers by sales count', function () {
    $best = createHomePageProduct(['sales_count' => 30, 'name' => 'Best Seller Alpha']);
    $worst = createHomePageProduct(['sales_count' => 1, 'name' => 'Worst Seller Beta']);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSeeInOrder([$best->name, $worst->name]);
});

test('home page shows newest products first in new arrivals', function () {
    $old = createHomePageProduct(['name' => 'Old Arrival Alpha', 'created_at' => now()->subDays(10)]);
    $new = createHomePageProduct(['name' => 'New Arrival Beta', 'created_at' => now()]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSeeInOrder([$new->name, $old->name]);
});

test('home page shows tagged products in special offer and hides the rest', function () {
    $offer = createHomePageProduct(['name' => 'Special Offer Alpha']);
    $plain = createHomePageProduct(['name' => 'Plain Product Beta']);
    $tag = Tag::firstOrCreate(['slug' => 'special_offer'], ['name' => 'Special Offer']);
    $offer->tags()->sync([$tag->id]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee($offer->name);

    expect(Product::published()->byTag('special_offer')->pluck('name')->all())
        ->toContain($offer->name)
        ->not->toContain($plain->name);
});

test('home page hides unpublished products everywhere', function () {
    createHomePageProduct(['status' => 'unpublished', 'name' => 'Hidden Draft Product', 'hit_count' => 999, 'sales_count' => 999]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertDontSee('Hidden Draft Product');
});

test('viewing a product increments its hit count', function () {
    $product = createHomePageProduct(['hit_count' => 5]);

    $this->get(route('products.show', $product))->assertOk();

    expect($product->fresh()->hit_count)->toBe(6);
});

test('marking an order delivered increments product sales count once', function () {
    $admin = Admin::factory()->create();
    $product = createHomePageProduct(['sales_count' => 0]);
    $order = Order::create([
        'user_id' => User::factory()->create()->id,
        'order_total' => 100,
        'order_status' => 'processing',
        'delivery_address' => 'House 1, Road 2, Dhaka',
        'delivery_status' => 'shipped',
        'payment_type' => 'cash_on_delivery',
        'payment_status' => 'pending',
    ]);
    $order->details()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'product_price' => $product->selling_amount,
        'product_quantity' => 3,
    ]);

    $this->actingAs($admin, 'admin')->put(route('admin.orders.update', $order), [
        'order_status' => 'processing',
        'delivery_status' => 'delivered',
        'payment_status' => 'pending',
        'delivery_address' => $order->delivery_address,
    ])->assertRedirect(route('admin.orders.show', $order));

    expect($product->fresh()->sales_count)->toBe(3);

    // Re-saving an already delivered order must not double count.
    $this->actingAs($admin, 'admin')->put(route('admin.orders.update', $order->fresh()), [
        'order_status' => 'completed',
        'delivery_status' => 'delivered',
        'payment_status' => 'paid',
        'delivery_address' => $order->delivery_address,
    ]);

    expect($product->fresh()->sales_count)->toBe(3);
});

test('returning a delivered order decrements product sales count', function () {
    $admin = Admin::factory()->create();
    $product = createHomePageProduct(['sales_count' => 5]);
    $order = Order::create([
        'user_id' => User::factory()->create()->id,
        'order_total' => 100,
        'order_status' => 'processing',
        'delivery_address' => 'House 1, Road 2, Dhaka',
        'delivery_status' => 'delivered',
        'payment_type' => 'cash_on_delivery',
        'payment_status' => 'paid',
    ]);
    $order->details()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'product_price' => $product->selling_amount,
        'product_quantity' => 2,
    ]);

    $this->actingAs($admin, 'admin')->put(route('admin.orders.update', $order), [
        'order_status' => 'processing',
        'delivery_status' => 'returned',
        'payment_status' => 'paid',
        'delivery_address' => $order->delivery_address,
    ])->assertRedirect(route('admin.orders.show', $order));

    expect($product->fresh()->sales_count)->toBe(3);
});

test('admin can toggle category featured flag', function () {
    $admin = Admin::factory()->create();
    $category = Category::factory()->create(['is_featured' => false]);

    $this->actingAs($admin, 'admin')->patch(route('admin.categories.featured', $category))->assertRedirect();

    expect($category->fresh()->is_featured)->toBeTrue();
});
