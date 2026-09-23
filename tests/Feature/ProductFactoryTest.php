<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Unit;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

test('factory builds products from the downloaded image dataset', function () {
    $product = Product::factory()->create();

    expect($product->featured_image)->toStartWith('uploads/products/');
    expect(file_exists(public_path($product->featured_image)))->toBeTrue();
    expect(Str::slug($product->name))
        ->toBe(Str::lower(pathinfo($product->featured_image, PATHINFO_FILENAME)));
    expect($product->subCategory->category_id)->toBe($product->category_id);
});

test('factory reuses catalog rows instead of duplicating them', function () {
    Product::factory()->count(30)->create();

    expect(Category::count())->toBeLessThanOrEqual(18);
    expect(Product::query()->whereHas('subCategory', function ($query) {
        $query->whereColumn('sub_categories.category_id', 'products.category_id');
    })->count())->toBe(30);
});

test('factory keeps selling price at or below regular price', function () {
    Product::factory()->count(20)->create()->each(function (Product $product) {
        expect((float) $product->selling_amount)->toBeLessThanOrEqual((float) $product->regular_amount);
        expect((float) $product->regular_amount)->toBeGreaterThan(0);
    });
});

test('factory respects explicit attribute overrides', function () {
    $category = Category::factory()->create();
    $subCategory = SubCategory::factory()->create(['category_id' => $category->id]);
    $brand = Brand::factory()->create();
    $unit = Unit::factory()->create();

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'sub_category_id' => $subCategory->id,
        'brand_id' => $brand->id,
        'unit_id' => $unit->id,
        'name' => 'Override Product Name',
        'featured_image' => null,
    ]);

    expect($product->category_id)->toBe($category->id)
        ->and($product->sub_category_id)->toBe($subCategory->id)
        ->and($product->brand_id)->toBe($brand->id)
        ->and($product->unit_id)->toBe($unit->id)
        ->and($product->name)->toBe('Override Product Name')
        ->and($product->featured_image)->toBeNull();
});

test('factory maps department slugs to the right catalog line', function (string $slug, string $category, string $subCategory, string $band) {
    expect(ProductFactory::lineFromSlug($slug))->toBe([$category, $subCategory, $band]);
})->with([
    'laptop' => ['asus-vivobook-go-15-e1504ta-laptop', 'Laptop', 'All Laptop', 'laptop'],
    'router' => ['tenda-be12-pro-be7200-router', 'Networking', 'Router', 'networking'],
    'headset' => ['logitech-h111-stereo-headset', 'Accessories', 'Headphone', 'accessories'],
    'printer' => ['canon-pixma-mg2570s-printer', 'Office Equipment', 'Printer', 'office'],
    'laser printer' => ['pantum-p2500-laser-printer', 'Office Equipment', 'Laser Printer', 'office'],
    'air fryer' => ['philips-na110-00-air-fryer', 'Appliance', 'Air Fryer', 'appliance'],
    'cc camera' => ['dahua-hac-t1a21p-u-il-a-2mp-eyeball-cc-camera', 'Security', 'CC Camera', 'security'],
    'wifi camera' => ['tenda-cp6-2k-security-pan-tilt-camera', 'Security', 'Portable WiFi Camera', 'security'],
    'dvr' => ['hikvision-ds-7104hghi-m1-t-dvr', 'Security', 'DVR', 'security'],
    'nas' => ['synology-diskstation-ds223j-2-bay-nas-enclosure', 'Server & Storage', 'NAS Storage', 'server'],
    'gpu server' => ['asus-esc8000a-e13p-gpu-server', 'Server & Storage', 'GPU Server', 'server'],
    'antivirus' => ['eset-internet-security-antivirus-one-user', 'Software', 'Antivirus', 'software'],
    'smart tv' => ['rowa-43u62-43-inch-4k-android-smart-tv', 'TV', 'Smart TV', 'tv'],
    'led tv' => ['xiaomi-tv-a-pro-32', 'TV', 'LED TV', 'tv'],
    'iphone' => ['iphone-17', 'Phone', 'iPhone', 'phone'],
    'pendrive' => ['adata-uv128-64gb', 'Accessories', 'Pen Drive', 'accessories'],
    'money counter' => ['apollo-ap-800s-money-counting-machine', 'Office Equipment', 'Money Counting Machine', 'office'],
    'console' => ['sony-playstation-5-slim-gaming-console', 'Gaming', 'Gaming Console', 'gaming'],
    'gaming chair' => ['havit-gc933-gaming-chair', 'Gaming', 'Gaming Chair', 'gaming'],
    'gaming desk' => ['cougar-e-star-140-gaming-desk', 'Gaming', 'Gaming Desk', 'gaming'],
    'vr' => ['meta-quest-3s-128gb-vr-headset', 'Gaming', 'VR', 'gaming'],
    'vr console' => ['sony-playstation-vr2', 'Gaming', 'VR', 'gaming'],
    'vr phone brand' => ['samsung-galaxy-xr', 'Gaming', 'VR', 'gaming'],
    'racing wheel' => ['pxn-v9-racing-wheel', 'Gaming', 'Racing Wheel', 'gaming'],
    'driving force' => ['logitech-driving-force-shifter', 'Gaming', 'Racing Wheel', 'gaming'],
    'xbox' => ['xbox-series-x-white', 'Gaming', 'Gaming Console', 'gaming'],
]);

test('factory forImage state builds from a specific file', function () {
    $product = Product::factory()->forImage('tenda-be12-pro-be7200-router.webp')->create();

    expect($product->featured_image)->toBe('uploads/products/tenda-be12-pro-be7200-router.webp');
    expect($product->category->name)->toBe('Networking');
    expect($product->subCategory->name)->toBe('Router');
    expect($product->brand->name)->toBe('Tenda');
    expect($product->name)->toBe('Tenda BE12 Pro BE7200 Router');
    expect((float) $product->regular_amount)->toBeGreaterThanOrEqual(1000)
        ->and((float) $product->regular_amount)->toBeLessThanOrEqual(90000);
});

test('factory never assigns the same featured image twice', function () {
    $first = Product::factory()->create();
    $second = Product::factory()->create();

    expect($second->featured_image)->not->toBe($first->featured_image);
});

test('factory assigns distinct images within one batch', function () {
    $products = Product::factory()->count(30)->create();

    expect($products->pluck('featured_image')->unique()->count())->toBe(30);
});

test('unused seed images exclude files taken by products', function () {
    Product::factory()->forImage('tenda-be12-pro-be7200-router.webp')->create();

    expect(ProductFactory::unusedSeedImages())->not->toContain('tenda-be12-pro-be7200-router.webp');
});

test('seeding stages fixture images into public uploads', function () {
    $product = Product::factory()->forImage('tenda-be12-pro-be7200-router.webp')->create();

    expect($product->featured_image)->toBe('uploads/products/tenda-be12-pro-be7200-router.webp')
        ->and(Storage::disk('public')->exists('uploads/products/tenda-be12-pro-be7200-router.webp'))->toBeTrue()
        ->and(file_exists(public_path('uploads/products/tenda-be12-pro-be7200-router.webp')))->toBeTrue();

    // Re-staging the same file is idempotent.
    expect(ProductFactory::stageSeedImage('tenda-be12-pro-be7200-router.webp'))
        ->toBe('uploads/products/tenda-be12-pro-be7200-router.webp');
});
