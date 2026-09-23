<?php

use App\Models\Admin;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\HeroSlider;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Tag;

function createCmsProduct(array $overrides = []): Product
{
    $category = Category::factory()->create();

    return Product::factory()->create(array_merge([
        'category_id' => $category->id,
        'sub_category_id' => SubCategory::factory()->create(['category_id' => $category->id])->id,
    ], $overrides));
}

function tagProduct(Product $product, string $slug): void
{
    $tag = Tag::firstOrCreate(['slug' => $slug], ['name' => $slug]);
    $product->tags()->syncWithoutDetaching([$tag->id]);
}

test('home page renders active sliders in order and hides inactive', function () {
    HeroSlider::factory()->create(['title' => 'First Slide Alpha', 'sort_order' => 0, 'is_active' => true]);
    HeroSlider::factory()->create(['title' => 'Second Slide Beta', 'sort_order' => 1, 'is_active' => true]);
    HeroSlider::factory()->create(['title' => 'Hidden Slide Gamma', 'is_active' => false]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSeeInOrder(['First Slide Alpha', 'Second Slide Beta']);
    $response->assertDontSee('Hidden Slide Gamma');
});

test('home page renders one banner per location', function () {
    Banner::factory()->create(['location' => 'hero_sidebar_top', 'title' => 'Top Banner Alpha']);
    Banner::factory()->create(['location' => 'mid_left', 'title' => 'Mid Left Banner Beta']);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Top Banner Alpha');
    $response->assertSee('Mid Left Banner Beta');
});

test('home page renders featured categories with subcategories', function () {
    $category = Category::factory()->create(['name' => 'Featured Category Alpha', 'is_featured' => true, 'status' => 'published']);
    $sub = SubCategory::factory()->create(['category_id' => $category->id, 'name' => 'Sub Alpha One']);
    Category::factory()->create(['name' => 'Plain Category Beta', 'is_featured' => false, 'status' => 'unpublished']);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Featured Category Alpha');
    $response->assertSee('Sub Alpha One');
    $response->assertDontSee('Plain Category Beta');
});

test('home page renders featured brands and hides the rest', function () {
    Brand::factory()->create(['name' => 'Featured Brand Alpha', 'is_featured' => true, 'status' => 'published']);
    Brand::factory()->create(['name' => 'Plain Brand Beta', 'is_featured' => false]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Featured Brand Alpha');
    $response->assertDontSee('Plain Brand Beta');
});

test('home page special offer and top rated come from tags', function () {
    $offer = createCmsProduct(['name' => 'Tagged Offer Alpha']);
    $rated = createCmsProduct(['name' => 'Tagged Rated Beta']);
    $plain = createCmsProduct(['name' => 'Untagged Plain Gamma']);
    tagProduct($offer, Tag::SPECIAL_OFFER);
    tagProduct($rated, Tag::TOP_RATED);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Tagged Offer Alpha');
    $response->assertSee('Tagged Rated Beta');

    expect(Product::published()->byTag(Tag::SPECIAL_OFFER)->pluck('name')->all())
        ->toContain('Tagged Offer Alpha')
        ->not->toContain('Untagged Plain Gamma');
    expect(Product::published()->byTag(Tag::TOP_RATED)->pluck('name')->all())
        ->toContain('Tagged Rated Beta')
        ->not->toContain('Untagged Plain Gamma');
});

test('home page renders active flash deal with countdown date', function () {
    $product = createCmsProduct(['name' => 'Deal Product Alpha']);
    $deal = FlashDeal::factory()->create([
        'product_id' => $product->id,
        'sale_price' => 99.99,
        'ends_at' => now()->addDays(3),
        'is_active' => true,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Deal Product Alpha');
    $response->assertSee('data-ends-at="'.$deal->fresh()->ends_at->toIso8601String().'"', false);
});

test('admin can manage hero sliders', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin')
        ->post(route('admin.hero-sliders.store'), ['title' => 'Slider Alpha', 'sort_order' => 0])
        ->assertRedirect(route('admin.hero-sliders.index'));

    $this->assertDatabaseHas('hero_sliders', ['title' => 'Slider Alpha']);

    $slider = HeroSlider::where('title', 'Slider Alpha')->first();

    $this->actingAs($admin, 'admin')
        ->put(route('admin.hero-sliders.update', $slider), ['title' => 'Slider Alpha Updated'])
        ->assertRedirect(route('admin.hero-sliders.index'));

    $this->actingAs($admin, 'admin')
        ->patch(route('admin.hero-sliders.status', $slider))
        ->assertRedirect(route('admin.hero-sliders.index'));

    expect($slider->fresh()->is_active)->toBeFalse();
});

test('admin can manage banners with location', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin')
        ->post(route('admin.banners.store'), ['location' => 'mid_left', 'title' => 'Banner Alpha'])
        ->assertRedirect(route('admin.banners.index'));

    $this->assertDatabaseHas('banners', ['location' => 'mid_left', 'title' => 'Banner Alpha']);

    $this->actingAs($admin, 'admin')
        ->post(route('admin.banners.store'), ['title' => 'Missing Location'])
        ->assertSessionHasErrors('location');
});

test('admin can manage flash deals', function () {
    $admin = Admin::factory()->create();
    $product = createCmsProduct();

    $this->actingAs($admin, 'admin')
        ->post(route('admin.flash-deals.store'), [
            'product_id' => $product->id,
            'sale_price' => 123.45,
            'ends_at' => now()->addDays(2)->format('Y-m-d\TH:i'),
        ])
        ->assertRedirect(route('admin.flash-deals.index'));

    $this->assertDatabaseHas('flash_deals', ['product_id' => $product->id]);
});

test('admin can toggle brand featured flag', function () {
    $admin = Admin::factory()->create();
    $brand = Brand::factory()->create(['is_featured' => false]);

    $this->actingAs($admin, 'admin')
        ->patch(route('admin.brands.featured', $brand))
        ->assertRedirect(route('admin.brands.index'));

    expect($brand->fresh()->is_featured)->toBeTrue();
});

test('admin homepage pages render', function () {
    $admin = Admin::factory()->create();
    $slider = HeroSlider::factory()->create();
    $banner = Banner::factory()->create(['location' => 'mid_left']);
    $deal = FlashDeal::factory()->create();

    $this->actingAs($admin, 'admin')->get(route('admin.hero-sliders.index'))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.hero-sliders.create'))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.hero-sliders.edit', $slider))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.banners.index'))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.banners.create'))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.banners.edit', $banner))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.flash-deals.index'))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.flash-deals.create'))->assertOk();
    $this->actingAs($admin, 'admin')->get(route('admin.flash-deals.edit', $deal))->assertOk();
});
