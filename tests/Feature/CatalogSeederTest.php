<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Unit;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\SubCategoryFactory;
use Database\Factories\UnitFactory;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\SubCategorySeeder;
use Database\Seeders\UnitSeeder;

test('catalog seeders plant the full canonical catalog', function () {
    $this->seed([CategorySeeder::class, SubCategorySeeder::class, BrandSeeder::class, UnitSeeder::class]);

    expect(Category::count())->toBe(count(CategoryFactory::STAR_TECH_CATEGORIES));
    expect(Brand::count())->toBeGreaterThanOrEqual(count(BrandFactory::STAR_TECH_BRANDS));
    expect(Unit::count())->toBe(count(UnitFactory::STAR_TECH_UNITS));

    foreach (CategoryFactory::STAR_TECH_CATEGORIES as $name) {
        expect(Category::where('name', $name)->exists())->toBeTrue();
    }

    foreach (SubCategoryFactory::STAR_TECH_SUB_CATEGORIES as $categoryName => $names) {
        $category = Category::where('name', $categoryName)->firstOrFail();

        foreach ($names as $name) {
            expect(SubCategory::where('category_id', $category->id)->where('name', $name)->exists())->toBeTrue();
        }
    }

    foreach (UnitFactory::STAR_TECH_UNITS as $name => $code) {
        expect(Unit::where('name', $name)->where('code', $code)->exists())->toBeTrue();
    }
});

test('catalog seeders are safe to rerun', function () {
    $seeders = [CategorySeeder::class, SubCategorySeeder::class, BrandSeeder::class, UnitSeeder::class];

    $this->seed($seeders);
    $counts = [Category::count(), SubCategory::count(), Brand::count(), Unit::count()];

    $this->seed($seeders);

    expect([Category::count(), SubCategory::count(), Brand::count(), Unit::count()])->toBe($counts);
});

test('database seeder builds catalog before products', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Product::count())->toBeGreaterThan(0);
    expect(Product::query()->whereHas('subCategory', function ($query) {
        $query->whereColumn('sub_categories.category_id', 'products.category_id');
    })->count())->toBe(Product::count());
    expect(Category::count())->toBe(count(CategoryFactory::STAR_TECH_CATEGORIES));
});
