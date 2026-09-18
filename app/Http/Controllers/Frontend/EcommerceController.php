<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    public function index(): View
    {
        $trendingProducts = Product::query()
            ->where('status', 'published')
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.home.index', [
            'trendingProducts' => $trendingProducts,
        ]);
    }

    public function products(Request $request): View
    {
        $products = Product::query()
            ->where('status', 'published')
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->filled('subcategory'), fn ($query) => $query->where('sub_category_id', $request->integer('subcategory')))
            ->orderBy('name')
            ->paginate(12);

        return view('frontend.products.index', [
            'products' => $products,
        ]);
    }

    public function show(Product $product): View
    {
        abort_if($product->status !== 'published', 404);

        $product->load(['category', 'subCategory', 'brand', 'unit', 'images']);

        return view('frontend.products.show', [
            'product' => $product,
        ]);
    }
}
