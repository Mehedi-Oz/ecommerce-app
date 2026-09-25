<?php

use App\Models\Admin;
use App\Models\Category;

test('admin cannot feature a seventh category via toggle', function () {
    $admin = Admin::factory()->create();
    Category::factory()->count(Category::MAX_FEATURED)->create(['is_featured' => true]);
    $category = Category::factory()->create(['is_featured' => false]);

    $this->actingAs($admin, 'admin')->patch(route('admin.categories.featured', $category))->assertRedirect();

    expect($category->fresh()->is_featured)->toBeFalse();
});

test('admin can still unfeature a category when six are featured', function () {
    $admin = Admin::factory()->create();
    $category = Category::factory()->create(['is_featured' => true]);
    Category::factory()->count(Category::MAX_FEATURED - 1)->create(['is_featured' => true]);

    $this->actingAs($admin, 'admin')->patch(route('admin.categories.featured', $category))->assertRedirect();

    expect($category->fresh()->is_featured)->toBeFalse();
});

test('admin cannot create a seventh featured category', function () {
    $admin = Admin::factory()->create();
    Category::factory()->count(Category::MAX_FEATURED)->create(['is_featured' => true]);
    $data = Category::factory()->make(['is_featured' => true])->only(['name', 'description', 'status', 'is_featured']);

    $this->actingAs($admin, 'admin')->post(route('admin.categories.store'), $data)->assertRedirect();

    expect(Category::count())->toBe(Category::MAX_FEATURED);
});

test('admin cannot feature a category via update when six are featured', function () {
    $admin = Admin::factory()->create();
    Category::factory()->count(Category::MAX_FEATURED)->create(['is_featured' => true]);
    $category = Category::factory()->create(['is_featured' => false]);

    $this->actingAs($admin, 'admin')->put(route('admin.categories.update', $category), [
        'name' => $category->name,
        'is_featured' => true,
    ])->assertRedirect();

    expect($category->fresh()->is_featured)->toBeFalse();
});

test('admin can update an already featured category when six are featured', function () {
    $admin = Admin::factory()->create();
    Category::factory()->count(Category::MAX_FEATURED - 1)->create(['is_featured' => true]);
    $category = Category::factory()->create(['is_featured' => true]);

    $this->actingAs($admin, 'admin')->put(route('admin.categories.update', $category), [
        'name' => 'Updated Category Name',
        'is_featured' => true,
    ])->assertRedirect();

    expect($category->fresh()->name)->toBe('Updated Category Name')
        ->and($category->fresh()->is_featured)->toBeTrue();
});
