<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Testing\TestResponse;

function assertTabTitle(TestResponse $response, string $expected): void
{
    preg_match('/<title>\s*(.*?)\s*<\/title>/s', $response->getContent(), $matches);

    expect($matches[1] ?? null)->toBe($expected);
}

test('storefront pages render their own browser tab title', function () {
    assertTabTitle($this->get(route('home'))->assertOk(), 'EcommerceApp');
    assertTabTitle($this->get(route('products'))->assertOk(), 'Products');
    assertTabTitle($this->get(route('cart.index'))->assertOk(), 'Cart');

    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'sub_category_id' => SubCategory::factory()->create(['category_id' => $category->id])->id,
        'featured_image' => null,
        'stock_amount' => 10,
    ]);
    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1])->assertRedirect();

    assertTabTitle($this->get(route('checkout'))->assertOk(), 'Checkout');
});

test('product page title shows the product name', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'sub_category_id' => SubCategory::factory()->create(['category_id' => $category->id])->id,
        'featured_image' => null,
        'name' => 'Title Check Widget',
    ]);

    assertTabTitle($this->get(route('products.show', $product))->assertOk(), 'Title Check Widget');
});

test('admin pages render their own browser tab title', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    assertTabTitle($this->get(route('admin.dashboard'))->assertOk(), 'Admin | Dashboard');
});

test('admin login page renders its own browser tab title', function () {
    assertTabTitle($this->get(route('admin.login'))->assertOk(), 'Admin | Login');
});
