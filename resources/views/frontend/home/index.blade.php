@extends('frontend.layouts.master')

@section('title')
    {{ __('EcommerceApp') }}
@endsection

@section('content')
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                    <div class="slider-head">

                        <div class="hero-slider">

                            @forelse ($heroSliders as $slider)
                                <div class="single-slider"
                                    style="background-image: url('{{ $slider->background_image ? asset($slider->background_image) : asset('assets/frontend/images/hero/slider-bg1.jpg') }}');">
                                    <div class="content">
                                        <h2><span>{{ $slider->subtitle }}</span>
                                            {{ $slider->title }}
                                        </h2>
                                        @if ($slider->description)
                                            <p>{{ $slider->description }}</p>
                                        @endif
                                        @if ($slider->price_text)
                                            <h3><span>{{ __('Now Only') }}</span> {{ $slider->price_text }}</h3>
                                        @endif
                                        <div class="button">
                                            <a href="{{ str_starts_with($slider->button_url ?? '', 'http') ? $slider->button_url : url($slider->button_url ?? '/products') }}"
                                                class="btn">{{ $slider->button_text ?? __('Shop Now') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="single-slider"
                                    style="background-image: url('{{ asset('assets/frontend/images/hero/slider-bg1.jpg') }}');">
                                    <div class="content">
                                        <h2><span>{{ __('Big Sale Offer') }}</span>
                                            {{ __('Shop Now') }}
                                        </h2>
                                        <p>{{ __('Discover our latest collection.') }}</p>
                                        <div class="button">
                                            <a href="{{ route('products') }}" class="btn">{{ __('Shop Now') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforelse

                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12 md-custom-padding">

                            @if ($heroTopBanner)
                                <div class="hero-small-banner"
                                    style="background-image: url('{{ $heroTopBanner->image ? asset($heroTopBanner->image) : asset('assets/frontend/images/hero/slider-bnr.jpg') }}');">
                                    <div class="content">
                                        <h2>
                                            <span>{{ $heroTopBanner->description }}</span>
                                            {{ $heroTopBanner->title }}
                                        </h2>
                                        @if ($heroTopBanner->button_text)
                                            <div class="button">
                                                <a class="btn"
                                                    href="{{ str_starts_with($heroTopBanner->button_url ?? '', 'http') ? $heroTopBanner->button_url : url($heroTopBanner->button_url ?? '/products') }}">{{ $heroTopBanner->button_text }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="hero-small-banner"
                                    style="background-image: url('{{ asset('assets/frontend/images/hero/slider-bnr.jpg') }}');">
                                    <div class="content">
                                        <h2>
                                            <span>{{ __('New line required') }}</span>
                                            {{ __('iPhone 18 Pro Max') }}
                                        </h2>
                                        <h3>{{ __('৳ 259.99') }}</h3>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-lg-12 col-md-6 col-12">

                            @if ($heroBottomBanner)
                                <div class="hero-small-banner style2"
                                    @if ($heroBottomBanner->image) style="background-image: url('{{ asset($heroBottomBanner->image) }}');" @endif>
                                    <div class="content">
                                        <h2>{{ $heroBottomBanner->title }}</h2>
                                        @if ($heroBottomBanner->description)
                                            <p>{{ $heroBottomBanner->description }}</p>
                                        @endif
                                        @if ($heroBottomBanner->button_text)
                                            <div class="button">
                                                <a class="btn"
                                                    href="{{ str_starts_with($heroBottomBanner->button_url ?? '', 'http') ? $heroBottomBanner->button_url : url($heroBottomBanner->button_url ?? '/products') }}">{{ $heroBottomBanner->button_text }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="hero-small-banner style2">
                                    <div class="content">
                                        <h2>{{ __('Weekly Sale!') }}</h2>
                                        <p>{{ __('Saving up to 50% off all online store items this week.') }}</p>
                                        <div class="button">
                                            <a class="btn" href="{{ route('products') }}">{{ __('Shop Now') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-categories section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{ __('Featured Categories') }}</h2>
                        <p>{{ __('Explore our handpicked categories to find exactly what you are looking for.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($featuredCategories as $category)
                    <div class="col-lg-4 col-md-6 col-12">

                        <div class="single-category">
                            <h3 class="heading">{{ $category->name }}</h3>
                            <ul>
                                @foreach ($category->subCategories->take(4) as $subCategory)
                                    <li><a
                                            href="{{ route('products', ['category' => $category->id, 'subcategory' => $subCategory->id]) }}">{{ $subCategory->name }}</a>
                                    </li>
                                @endforeach
                                <li><a
                                        href="{{ route('products', ['category' => $category->id]) }}">{{ __('View All') }}</a>
                                </li>
                            </ul>
                            <div class="images">
                                <img src="{{ $category->image ? asset($category->image) : asset('assets/frontend/images/featured-categories/fetured-item-1.png') }}"
                                    alt="{{ $category->name }}">
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-12">
                        <p>{{ __('No featured categories yet') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{ __('Trending Product') }}</h2>
                        <p>{{ __('Discover the most popular products our customers love right now.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($trendingProducts as $product)
                    <div class="col-lg-3 col-md-6 col-12">

                        <div class="single-product">
                            <div class="product-image">
                                <img src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/frontend/images/products/product-1.jpg') }}"
                                    alt="{{ $product->name }}">
                                @php
                                    $discount = $product->regular_amount > $product->selling_amount
                                        ? round((($product->regular_amount - $product->selling_amount) / $product->regular_amount) * 100)
                                        : null;
                                @endphp
                                @if ($discount)
                                    <span class="sale-tag">-{{ $discount }}%</span>
                                @endif
                                <div class="button">
                                    @if ($product->stock_amount > 0)
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <button type="submit" class="btn"><i class="lni lni-cart"></i>
                                                {{ __('Add to Cart') }}</button>
                                        </form>
                                    @else
                                        <button type="button" class="btn" disabled><i class="lni lni-cart"></i>
                                            {{ __('Stock Out') }}</button>
                                    @endif
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
        </div>
    </section>

    <section class="banner section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    @if ($midLeftBanner)
                        <div class="single-banner"
                            style="background-image:url('{{ $midLeftBanner->image ? asset($midLeftBanner->image) : asset('assets/frontend/images/banner/banner-1-bg.jpg') }}')">
                            <div class="content">
                                <h2>{{ $midLeftBanner->title }}</h2>
                                @if ($midLeftBanner->description)
                                    <p>{{ $midLeftBanner->description }}</p>
                                @endif
                                @if ($midLeftBanner->button_text)
                                    <div class="button">
                                        <a href="{{ str_starts_with($midLeftBanner->button_url ?? '', 'http') ? $midLeftBanner->button_url : url($midLeftBanner->button_url ?? '/products') }}"
                                            class="btn">{{ $midLeftBanner->button_text }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="single-banner"
                            style="background-image:url('{{ asset('assets/frontend/images/banner/banner-1-bg.jpg') }}')">
                            <div class="content">
                                <h2>{{ __('Smart Watch 2.0') }}</h2>
                                <p>{{ __('Space Gray Aluminum Case with') }} <br>{{ __('Black/Volt Real Sport Band') }}
                                </p>
                                <div class="button">
                                    <a href="{{ route('products') }}" class="btn">{{ __('View Details') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    @if ($midRightBanner)
                        <div class="single-banner custom-responsive-margin"
                            style="background-image:url('{{ $midRightBanner->image ? asset($midRightBanner->image) : asset('assets/frontend/images/banner/banner-2-bg.jpg') }}')">
                            <div class="content">
                                <h2>{{ $midRightBanner->title }}</h2>
                                @if ($midRightBanner->description)
                                    <p>{{ $midRightBanner->description }}</p>
                                @endif
                                @if ($midRightBanner->button_text)
                                    <div class="button">
                                        <a href="{{ str_starts_with($midRightBanner->button_url ?? '', 'http') ? $midRightBanner->button_url : url($midRightBanner->button_url ?? '/products') }}"
                                            class="btn">{{ $midRightBanner->button_text }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="single-banner custom-responsive-margin"
                            style="background-image:url('{{ asset('assets/frontend/images/banner/banner-2-bg.jpg') }}')">
                            <div class="content">
                                <h2>{{ __('Smart Headphone') }}</h2>
                                <p>{{ __('Immerse yourself in rich, crystal clear sound') }}
                                    <br>{{ __('with deep bass and long lasting comfort.') }}
                                </p>
                                <div class="button">
                                    <a href="{{ route('products') }}" class="btn">{{ __('Shop Now') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="special-offer section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{ __('Special Offer') }}</h2>
                        <p>{{ __('Grab amazing deals on your favorite products before they run out of stock.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="row">
                        @forelse ($specialOfferProducts as $product)
                            <div class="col-lg-4 col-md-4 col-12">

                                <div class="single-product">
                                    <div class="product-image">
                                        <img src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/frontend/images/products/product-3.jpg') }}"
                                            alt="{{ $product->name }}">
                                        @php
                                            $discount = $product->regular_amount > $product->selling_amount
                                                ? round((($product->regular_amount - $product->selling_amount) / $product->regular_amount) * 100)
                                                : null;
                                        @endphp
                                        @if ($discount)
                                            <span class="sale-tag">-{{ $discount }}%</span>
                                        @endif
                                        <div class="button">
                                            @if ($product->stock_amount > 0)
                                                <form action="{{ route('cart.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}" />
                                                    <input type="hidden" name="quantity" value="1" />
                                                    <button type="submit" class="btn"><i class="lni lni-cart"></i>
                                                        {{ __('Add to Cart') }}</button>
                                                </form>
                                            @else
                                                <button type="button" class="btn" disabled><i class="lni lni-cart"></i>
                                                    {{ __('Stock Out') }}</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        @if ($product->category)
                                            <span class="category">{{ $product->category->name }}</span>
                                        @endif
                                        <h4 class="title">
                                            <a
                                                href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="price">
                                            <span>৳ {{ number_format($product->selling_amount, 2) }}</span>
                                            @if ($product->regular_amount > $product->selling_amount)
                                                <span
                                                    class="discount-price">৳ {{ number_format($product->regular_amount, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="col-12">
                                <p>{{ __('No special offers available') }}</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($specialBanner)
                        <div class="single-banner right"
                            style="background-image:url('{{ $specialBanner->image ? asset($specialBanner->image) : asset('assets/frontend/images/banner/banner-3-bg.jpg') }}');margin-top: 30px;">
                            <div class="content">
                                <h2>{{ $specialBanner->title }}</h2>
                                @if ($specialBanner->description)
                                    <p>{{ $specialBanner->description }}</p>
                                @endif
                                @if ($specialBanner->button_text)
                                    <div class="button">
                                        <a href="{{ str_starts_with($specialBanner->button_url ?? '', 'http') ? $specialBanner->button_url : url($specialBanner->button_url ?? '/products') }}"
                                            class="btn">{{ $specialBanner->button_text }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="single-banner right"
                            style="background-image:url('{{ asset('assets/frontend/images/banner/banner-3-bg.jpg') }}');margin-top: 30px;">
                            <div class="content">
                                <h2>{{ __('Samsung Notebook 9') }} </h2>
                                <p>{{ __('Work anywhere with all day battery life') }}
                                    <br>{{ __('and a stunning, lightweight display.') }}
                                </p>
                                <div class="price">
                                    <span>{{ __('৳ 590.00') }}</span>
                                </div>
                                <div class="button">
                                    <a href="{{ route('products') }}" class="btn">{{ __('Shop Now') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    @if ($flashDeal && $flashDeal->product)
                        @php($dealProduct = $flashDeal->product)
                        <div class="offer-content" data-ends-at="{{ $flashDeal->ends_at->toIso8601String() }}">
                            <div class="image">
                                <img src="{{ $dealProduct->featured_image ? asset($dealProduct->featured_image) : asset('assets/frontend/images/offer/offer-image.jpg') }}"
                                    alt="{{ $dealProduct->name }}">
                                @php($dealDiscount = $dealProduct->regular_amount > $flashDeal->sale_price
                                    ? round((($dealProduct->regular_amount - $flashDeal->sale_price) / $dealProduct->regular_amount) * 100)
                                    : null)
                                @if ($dealDiscount)
                                    <span class="sale-tag">-{{ $dealDiscount }}%</span>
                                @endif
                            </div>
                            <div class="text">
                                <h2><a
                                        href="{{ route('products.show', $dealProduct) }}">{{ $dealProduct->name }}</a>
                                </h2>
                                <div class="price">
                                    <span>{{ __('৳ :price', ['price' => number_format($flashDeal->sale_price, 2)]) }}</span>
                                    <span
                                        class="discount-price">{{ __('৳ :price', ['price' => number_format($dealProduct->regular_amount, 2)]) }}</span>
                                </div>
                                @if ($dealProduct->short_description)
                                    <p>{{ $dealProduct->short_description }}</p>
                                @endif
                            </div>
                            <div class="box-head">
                                <div class="box">
                                    <h1 id="days">{{ __('000') }}</h1>
                                    <h2 id="daystxt">{{ __('Days') }}</h2>
                                </div>
                                <div class="box">
                                    <h1 id="hours">{{ __('00') }}</h1>
                                    <h2 id="hourstxt">{{ __('Hours') }}</h2>
                                </div>
                                <div class="box">
                                    <h1 id="minutes">{{ __('00') }}</h1>
                                    <h2 id="minutestxt">{{ __('Minutes') }}</h2>
                                </div>
                                <div class="box">
                                    <h1 id="seconds">{{ __('00') }}</h1>
                                    <h2 id="secondstxt">{{ __('Seconds') }}</h2>
                                </div>
                            </div>
                            <div style="display: none;background: rgb(204, 24, 24);" class="alert offer-expired-alert">
                                <h1 style="padding: 50px 80px;color: white;">{{ __('We are sorry, Event ended !') }}
                                </h1>
                            </div>
                        </div>
                    @else
                        <div class="offer-content">
                            <div class="image">
                                <img src="{{ asset('assets/frontend/images/offer/offer-image.jpg') }}" alt="#">
                                <span class="sale-tag">{{ __('-50%') }}</span>
                            </div>
                            <div class="text">
                                <h2><a href="{{ route('products') }}">{{ __('Bluetooth Headphone') }}</a></h2>
                                <div class="price">
                                    <span>{{ __('৳ 200.00') }}</span>
                                    <span class="discount-price">{{ __('৳ 400.00') }}</span>
                                </div>
                                <p>{{ __('Experience crystal clear audio with deep bass and a comfortable all day fit.') }}
                                </p>
                            </div>
                            <div class="box-head">
                                <div class="box">
                                    <h1 id="days">{{ __('000') }}</h1>
                                    <h2 id="daystxt">{{ __('Days') }}</h2>
                                </div>
                                <div class="box">
                                    <h1 id="hours">{{ __('00') }}</h1>
                                    <h2 id="hourstxt">{{ __('Hours') }}</h2>
                                </div>
                                <div class="box">
                                    <h1 id="minutes">{{ __('00') }}</h1>
                                    <h2 id="minutestxt">{{ __('Minutes') }}</h2>
                                </div>
                                <div class="box">
                                    <h1 id="seconds">{{ __('00') }}</h1>
                                    <h2 id="secondstxt">{{ __('Seconds') }}</h2>
                                </div>
                            </div>
                            <div style="display: none;background: rgb(204, 24, 24);" class="alert offer-expired-alert">
                                <h1 style="padding: 50px 80px;color: white;">{{ __('We are sorry, Event ended !') }}
                                </h1>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="home-product-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">{{ __('Best Sellers') }}</h4>

                    @forelse ($bestSellers as $product)
                        <div class="single-list">
                            <div class="list-image">
                                <a href="{{ route('products.show', $product) }}"><img
                                        src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/frontend/images/home-product-list/01.jpg') }}"
                                        alt="{{ $product->name }}"></a>
                            </div>
                            <div class="list-info">
                                <h3>
                                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                </h3>
                                <span>৳ {{ number_format($product->selling_amount, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <p>{{ __('No products available') }}</p>
                    @endforelse

                </div>
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">{{ __('New Arrivals') }}</h4>

                    @forelse ($newArrivals as $product)
                        <div class="single-list">
                            <div class="list-image">
                                <a href="{{ route('products.show', $product) }}"><img
                                        src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/frontend/images/home-product-list/04.jpg') }}"
                                        alt="{{ $product->name }}"></a>
                            </div>
                            <div class="list-info">
                                <h3>
                                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                </h3>
                                <span>৳ {{ number_format($product->selling_amount, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <p>{{ __('No products available') }}</p>
                    @endforelse

                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <h4 class="list-title">{{ __('Top Discounts') }}</h4>

                    @forelse ($topDiscounted as $product)
                        <div class="single-list">
                            <div class="list-image">
                                <a href="{{ route('products.show', $product) }}"><img
                                        src="{{ $product->featured_image ? asset($product->featured_image) : asset('assets/frontend/images/home-product-list/07.jpg') }}"
                                        alt="{{ $product->name }}"></a>
                            </div>
                            <div class="list-info">
                                <h3>
                                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                </h3>
                                <span>৳ {{ number_format($product->selling_amount, 2) }}</span>
                                @if ($product->regular_amount > $product->selling_amount)
                                    <span class="badge bg-danger ms-1 fw-normal align-middle" style="font-size: 0.5rem; padding: 0.05em 0.2em;">-{{ round(($product->regular_amount - $product->selling_amount) / $product->regular_amount * 100) }}%</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p>{{ __('No products available') }}</p>
                    @endforelse

                </div>
            </div>
        </div>
    </section>

    <div class="brands">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-12">
                    <h2 class="title">{{ __('Popular Brands') }}</h2>
                </div>
            </div>
            <div class="brands-logo-wrapper">
                <div class="brands-logo-carousel d-flex align-items-center justify-content-between">
                    @forelse ($featuredBrands as $brand)
                        <div class="brand-logo">
                            <img src="{{ $brand->image ? asset($brand->image) : asset('assets/frontend/images/brands/01.png') }}"
                                alt="{{ $brand->name }}" title="{{ $brand->name }}">
                        </div>
                    @empty
                        <div class="brand-logo">
                            <img src="{{ asset('assets/frontend/images/brands/01.png') }}" alt="#">
                        </div>
                        <div class="brand-logo">
                            <img src="{{ asset('assets/frontend/images/brands/02.png') }}" alt="#">
                        </div>
                        <div class="brand-logo">
                            <img src="{{ asset('assets/frontend/images/brands/03.png') }}" alt="#">
                        </div>
                        <div class="brand-logo">
                            <img src="{{ asset('assets/frontend/images/brands/04.png') }}" alt="#">
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
