<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;

function createSortingProduct(array $overrides = []): Product
{
    $category = Category::factory()->create();

    return Product::factory()->create(array_merge([
        'category_id' => $category->id,
        'sub_category_id' => SubCategory::factory()->create(['category_id' => $category->id])->id,
        'featured_image' => null,
    ], $overrides));
}

test('products default to popularity ordering', function () {
    $popular = createSortingProduct(['name' => 'Popular Sort Alpha', 'hit_count' => 100, 'sales_count' => 50]);
    $obscure = createSortingProduct(['name' => 'Obscure Sort Beta', 'hit_count' => 1, 'sales_count' => 0]);

    $this->get(route('products'))->assertOk()->assertSeeInOrder([$popular->name, $obscure->name]);
});

test('products sort low to high price', function () {
    $cheap = createSortingProduct(['name' => 'Cheap Sort Alpha', 'selling_amount' => 10]);
    $expensive = createSortingProduct(['name' => 'Expensive Sort Beta', 'selling_amount' => 500]);

    $this->get(route('products', ['sort' => 'price_asc']))->assertOk()->assertSeeInOrder([$cheap->name, $expensive->name]);
});

test('products sort high to low price', function () {
    $cheap = createSortingProduct(['name' => 'Cheap Sort Alpha', 'selling_amount' => 10]);
    $expensive = createSortingProduct(['name' => 'Expensive Sort Beta', 'selling_amount' => 500]);

    $this->get(route('products', ['sort' => 'price_desc']))->assertOk()->assertSeeInOrder([$expensive->name, $cheap->name]);
});

test('products sort a to z and z to a', function () {
    createSortingProduct(['name' => 'Apple Sort Product']);
    createSortingProduct(['name' => 'Zebra Sort Product']);

    $this->get(route('products', ['sort' => 'name_asc']))->assertOk()->assertSeeInOrder(['Apple Sort Product', 'Zebra Sort Product']);

    $this->get(route('products', ['sort' => 'name_desc']))->assertOk()->assertSeeInOrder(['Zebra Sort Product', 'Apple Sort Product']);
});

test('products rating sort uses best sellers and invalid sort falls back to popularity', function () {
    $best = createSortingProduct(['name' => 'Best Rated Sort Alpha', 'sales_count' => 40, 'hit_count' => 5]);
    $worst = createSortingProduct(['name' => 'Worst Rated Sort Beta', 'sales_count' => 1, 'hit_count' => 1]);

    $this->get(route('products', ['sort' => 'rating']))->assertOk()->assertSeeInOrder([$best->name, $worst->name]);

    $popular = createSortingProduct(['name' => 'Fallback Popular Alpha', 'hit_count' => 200, 'sales_count' => 100]);
    $plain = createSortingProduct(['name' => 'Fallback Plain Beta', 'hit_count' => 0, 'sales_count' => 0]);

    $this->get(route('products', ['sort' => 'not-a-sort']))->assertOk()->assertSeeInOrder([$popular->name, $plain->name]);
});

test('products sorting keeps category filter', function () {
    $category = Category::factory()->create();
    $subCategory = SubCategory::factory()->create(['category_id' => $category->id]);
    $otherCategory = Category::factory()->create();
    $otherSubCategory = SubCategory::factory()->create(['category_id' => $otherCategory->id]);

    $cheap = Product::factory()->create([
        'category_id' => $category->id,
        'sub_category_id' => $subCategory->id,
        'featured_image' => null,
        'name' => 'Filtered Cheap Alpha',
        'selling_amount' => 10,
    ]);
    $expensive = Product::factory()->create([
        'category_id' => $category->id,
        'sub_category_id' => $subCategory->id,
        'featured_image' => null,
        'name' => 'Filtered Expensive Beta',
        'selling_amount' => 900,
    ]);
    $outsider = Product::factory()->create([
        'category_id' => $otherCategory->id,
        'sub_category_id' => $otherSubCategory->id,
        'featured_image' => null,
        'name' => 'Outsider Product Gamma',
        'selling_amount' => 1,
    ]);

    $response = $this->get(route('products', ['category' => $category->id, 'sort' => 'price_asc']))->assertOk();

    $response->assertSeeInOrder([$cheap->name, $expensive->name]);
    $response->assertDontSee($outsider->name);
});

test('products highlights the selected category', function () {
    $active = Category::factory()->create(['name' => 'Active Category Alpha']);
    $inactive = Category::factory()->create(['name' => 'Inactive Category Beta']);

    $response = $this->get(route('products', ['category' => $active->id]))->assertOk();

    $response->assertSee($active->name);
    $response->assertSee($inactive->name);
    expect(substr_count($response->getContent(), 'class="active"'))->toBe(1);
    expect(substr_count($response->getContent(), 'aria-current="page"'))->toBe(1);
    expect($response->getContent())->toContain('aria-current="page"');
});

test('products highlights all products when no category is selected', function () {
    Category::factory()->create(['name' => 'Some Category Alpha']);

    $response = $this->get(route('products'))->assertOk();

    $response->assertSee('All Products');
    expect(substr_count($response->getContent(), 'class="active"'))->toBe(1);
    expect(substr_count($response->getContent(), 'aria-current="page"'))->toBe(1);
});
