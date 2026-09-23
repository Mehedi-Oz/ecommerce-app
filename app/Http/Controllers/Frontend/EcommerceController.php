<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\HeroSlider;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    public function index(): View
    {
        $trendingProducts = Product::query()
            ->published()
            ->trending()
            ->with('category')
            ->take(8)
            ->get();

        $specialOfferProducts = Product::query()
            ->published()
            ->byTag(Tag::SPECIAL_OFFER)
            ->with('category')
            ->take(3)
            ->get();

        $bestSellers = Product::query()
            ->published()
            ->bestSellers()
            ->take(3)
            ->get();

        $newArrivals = Product::query()
            ->published()
            ->newArrivals()
            ->take(3)
            ->get();

        $topRated = Product::query()
            ->published()
            ->byTag(Tag::TOP_RATED)
            ->take(3)
            ->get();

        $heroSliders = HeroSlider::query()->active()->ordered()->get();

        $heroTopBanner = Banner::query()->active()->forLocation('hero_sidebar_top')->ordered()->first();
        $heroBottomBanner = Banner::query()->active()->forLocation('hero_sidebar_bottom')->ordered()->first();
        $midLeftBanner = Banner::query()->active()->forLocation('mid_left')->ordered()->first();
        $midRightBanner = Banner::query()->active()->forLocation('mid_right')->ordered()->first();
        $specialBanner = Banner::query()->active()->forLocation('special_banner')->ordered()->first();

        $featuredCategories = Category::query()
            ->published()
            ->featured()
            ->with('subCategories')
            ->take(6)
            ->get();

        $featuredBrands = Brand::query()->published()->featured()->latest()->get();

        $flashDeal = FlashDeal::query()->active()->with('product.category')->latest()->first();

        return view('frontend.home.index', [
            'trendingProducts' => $trendingProducts,
            'specialOfferProducts' => $specialOfferProducts,
            'bestSellers' => $bestSellers,
            'newArrivals' => $newArrivals,
            'topRated' => $topRated,
            'heroSliders' => $heroSliders,
            'heroTopBanner' => $heroTopBanner,
            'heroBottomBanner' => $heroBottomBanner,
            'midLeftBanner' => $midLeftBanner,
            'midRightBanner' => $midRightBanner,
            'specialBanner' => $specialBanner,
            'featuredCategories' => $featuredCategories,
            'featuredBrands' => $featuredBrands,
            'flashDeal' => $flashDeal,
        ]);
    }

    public function products(Request $request): View
    {
        $sort = $request->string('sort', 'popularity')->toString();

        if (! in_array($sort, ['popularity', 'price_asc', 'price_desc', 'rating', 'name_asc', 'name_desc'], true)) {
            $sort = 'popularity';
        }

        $products = Product::query()
            ->where('status', 'published')
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->filled('subcategory'), fn ($query) => $query->where('sub_category_id', $request->integer('subcategory')))
            ->with('category')
            ->when($sort === 'popularity', fn ($query) => $query->orderByDesc('hit_count')->orderByDesc('sales_count')->latest())
            ->when($sort === 'price_asc', fn ($query) => $query->orderBy('selling_amount')->orderBy('name'))
            ->when($sort === 'price_desc', fn ($query) => $query->orderByDesc('selling_amount')->orderBy('name'))
            ->when($sort === 'rating', fn ($query) => $query->orderByDesc('sales_count')->orderByDesc('hit_count')->latest())
            ->when($sort === 'name_asc', fn ($query) => $query->orderBy('name'))
            ->when($sort === 'name_desc', fn ($query) => $query->orderByDesc('name'))
            ->paginate(12);

        return view('frontend.products.index', [
            'products' => $products,
            'sort' => $sort,
        ]);
    }

    public function show(Product $product): View
    {
        abort_if($product->status !== 'published', 404);

        $product->increment('hit_count');

        $product->load(['category', 'subCategory', 'brand', 'unit', 'images']);

        return view('frontend.products.show', [
            'product' => $product,
        ]);
    }
}
