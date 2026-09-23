<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;

function createDashboardProduct(array $overrides = []): Product
{
    $category = Category::factory()->create();

    return Product::factory()->create(array_merge([
        'category_id' => $category->id,
        'sub_category_id' => SubCategory::factory()->create(['category_id' => $category->id])->id,
    ], $overrides));
}

function createDashboardOrder(array $overrides = []): Order
{
    return Order::create(array_merge([
        'user_id' => User::factory()->create()->id,
        'order_total' => 100,
        'order_status' => 'completed',
        'delivery_address' => 'House 1, Road 2, Dhaka',
        'delivery_status' => 'delivered',
        'payment_type' => 'cash_on_delivery',
        'payment_status' => 'paid',
    ], $overrides));
}

test('dashboard shows live kpis excluding cancelled revenue', function () {
    $admin = Admin::factory()->create();
    createDashboardOrder(['order_total' => 100, 'order_status' => 'completed']);
    createDashboardOrder(['order_total' => 50, 'order_status' => 'cancelled']);
    createDashboardProduct(['status' => 'published']);

    $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'))->assertOk();

    $response->assertSee('100.00', false);
    $response->assertDontSee('150.00', false);
    $response->assertSee('TOTAL REVENUE', false);
    $response->assertSee('TOTAL ORDERS', false);
    $response->assertSee('TOTAL PRODUCTS', false);
    $response->assertSee('TOTAL CUSTOMERS', false);
});

test('dashboard flags products at five units or fewer as low stock', function () {
    $admin = Admin::factory()->create();
    createDashboardProduct(['name' => 'Almost Gone Widget', 'stock_amount' => 3]);
    createDashboardProduct(['name' => 'Plenty Left Widget', 'stock_amount' => 6]);

    $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'))->assertOk();

    $response->assertSee('3 left', false);
    $response->assertDontSee('6 left', false);
});

test('dashboard lists recent orders newest first', function () {
    $admin = Admin::factory()->create();
    $old = createDashboardOrder();
    $new = createDashboardOrder();

    Order::query()->whereKey($old->id)->update(['created_at' => now()->subDays(2)]);

    $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'))->assertOk();

    $response->assertSeeInOrder(["#{$new->id}", "#{$old->id}"]);
});
