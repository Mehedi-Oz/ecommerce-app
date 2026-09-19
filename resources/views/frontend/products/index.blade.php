@extends('frontend.layouts.master')

@section('title')
    {{ __('Category') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Shop Grid</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="javascript:void(0)">Shop</a></li>
                        <li>Shop Grid</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">

                    <div class="product-sidebar">

                        <div class="single-widget search">
                            <h3>Search Product</h3>
                            <form action="#">
                                <input type="text" placeholder="Search Here...">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>


                        <div class="single-widget">
                            <h3>All Categories</h3>
                            <ul class="list">
                                <li>
                                    <a href="{{ route('products') }}">{{ __('All Products') }}</a><span>({{ $categories->sum('products_count') }})</span>
                                </li>
                                @forelse ($categories as $category)
                                    <li>
                                        <a href="{{ route('products', ['category' => $category->id]) }}">{{ $category->name }}</a><span>({{ $category->products_count }})</span>
                                    </li>
                                @empty
                                    <li>
                                        <span>{{ __('No categories available') }}</span>
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                    </div>

                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-md-8 col-12">
                                    <div class="product-sorting">
                                        <label for="sorting">Sort by:</label>
                                        <select class="form-control" id="sorting">
                                            <option>Popularity</option>
                                            <option>Low - High Price</option>
                                            <option>High - Low Price</option>
                                            <option>Average Rating</option>
                                            <option>A - Z Order</option>
                                            <option>Z - A Order</option>
                                        </select>
                                        <h3 class="total-show-product">Showing: <span>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} items</span></h3>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-4 col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab"
                                                aria-controls="nav-grid" aria-selected="true"><i
                                                    class="lni lni-grid-alt"></i></button>
                                            <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab"
                                                aria-controls="nav-list" aria-selected="false"><i
                                                    class="lni lni-list"></i></button>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row">
                                    @forelse ($products as $product)
                                        <div class="col-lg-4 col-md-6 col-12">

                                            <div class="single-product">
                                                <div class="product-image">
                                                    @if ($product->featured_image)
                                                        <img src="{{ asset($product->featured_image) }}"
                                                            alt="{{ $product->name }}">
                                                    @endif
                                                    @php
                                                        $discount = $product->regular_amount > $product->selling_amount
                                                            ? round((($product->regular_amount - $product->selling_amount) / $product->regular_amount) * 100)
                                                            : null;
                                                    @endphp
                                                    @if ($discount)
                                                        <span class="sale-tag">-{{ $discount }}%</span>
                                                    @endif
                                                    <div class="button">
                                                        <form action="{{ route('cart.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}" />
                                                            <input type="hidden" name="quantity" value="1" />
                                                            <button type="submit" class="btn"><i
                                                                    class="lni lni-cart"></i> Add to Cart</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    @if ($product->category)
                                                        <span class="category">{{ $product->category->name }}</span>
                                                    @endif
                                                    <h4 class="title">
                                                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <div class="price">
                                                        <span>৳ {{ number_format($product->selling_amount, 2) }}</span>
                                                        @if ($product->regular_amount > $product->selling_amount)
                                                            <span class="discount-price">৳ {{ number_format($product->regular_amount, 2) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p>{{ __('No products available') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        @if ($products->hasPages())

                                            <div class="pagination left">
                                                {{ $products->withQueryString()->links() }}
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                                <div class="row">
                                    @forelse ($products as $product)
                                        <div class="col-lg-12 col-md-12 col-12">

                                            <div class="single-product">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-md-4 col-12">
                                                        <div class="product-image">
                                                            @if ($product->featured_image)
                                                                <img src="{{ asset($product->featured_image) }}"
                                                                    alt="{{ $product->name }}">
                                                            @endif
                                                            @php
                                                                $discount = $product->regular_amount > $product->selling_amount
                                                                    ? round((($product->regular_amount - $product->selling_amount) / $product->regular_amount) * 100)
                                                                    : null;
                                                            @endphp
                                                            @if ($discount)
                                                                <span class="sale-tag">-{{ $discount }}%</span>
                                                            @endif
                                                            <div class="button">
                                                                <form action="{{ route('cart.store') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}" />
                                                                    <input type="hidden" name="quantity" value="1" />
                                                                    <button type="submit" class="btn"><i
                                                                            class="lni lni-cart"></i> Add to
                                                                        Cart</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-12">
                                                        <div class="product-info">
                                                            @if ($product->category)
                                                                <span class="category">{{ $product->category->name }}</span>
                                                            @endif
                                                            <h4 class="title">
                                                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                                            </h4>
                                                            <div class="price">
                                                                <span>৳ {{ number_format($product->selling_amount, 2) }}</span>
                                                                @if ($product->regular_amount > $product->selling_amount)
                                                                    <span class="discount-price">৳ {{ number_format($product->regular_amount, 2) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p>{{ __('No products available') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        @if ($products->hasPages())

                                            <div class="pagination left">
                                                {{ $products->withQueryString()->links() }}
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
