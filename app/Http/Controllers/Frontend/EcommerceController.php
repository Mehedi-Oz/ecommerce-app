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
        return view('frontend.home.index');
    }

    public function category(Request $request): View
    {
        $products = Product::query()
            ->where('status', 'published')
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->when($request->filled('subcategory'), fn ($query) => $query->where('sub_category_id', $request->integer('subcategory')))
            ->orderBy('name')
            ->paginate(12);

        return view('frontend.categories.index', [
            'products' => $products,
        ]);
    }

    public function details(): View
    {
        return view('frontend.details.index');
    }
}
