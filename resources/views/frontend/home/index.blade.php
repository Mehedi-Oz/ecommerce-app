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

                            <div class="single-slider"
                                style="background-image: url('{{ asset('assets/frontend/images/hero/slider-bg1.jpg') }}');">
                                <div class="content">
                                    <h2><span>{{ __("No restocking fee (৳ 35 savings)") }}</span>
                                        {{ __('M75 Sport Watch') }}
                                    </h2>
                                    <p>{{ __('Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.') }}
                                    </p>
                                    <h3><span>{{ __('Now Only') }}</span> {{ __("৳ 320.99") }}</h3>
                                    <div class="button">
                                        <a href="{{ route('products') }}" class="btn">{{ __('Shop Now') }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="single-slider"
                                style="background-image: url('{{ asset('assets/frontend/images/hero/slider-bg2.jpg') }}');">
                                <div class="content">
                                    <h2><span>{{ __('Big Sale Offer') }}</span>
                                        {{ __('Get the Best Deal on CCTV Camera') }}
                                    </h2>
                                    <p>{{ __('Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.') }}
                                    </p>
                                    <h3><span>{{ __('Combo Only:') }}</span> {{ __("৳ 590.00") }}</h3>
                                    <div class="button">
                                        <a href="{{ route('products') }}" class="btn">{{ __('Shop Now') }}</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12 md-custom-padding">

                            <div class="hero-small-banner"
                                style="background-image: url('{{ asset('assets/frontend/images/hero/slider-bnr.jpg') }}');">
                                <div class="content">
                                    <h2>
                                        <span>{{ __('New line required') }}</span>
                                        {{ __('iPhone 18 Pro Max') }}
                                    </h2>
                                    <h3>{{ __("৳ 259.99") }}</h3>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 col-md-6 col-12">

                            <div class="hero-small-banner style2">
                                <div class="content">
                                    <h2>{{ __('Weekly Sale!') }}</h2>
                                    <p>{{ __('Saving up to 50% off all online store items this week.') }}</p>
                                    <div class="button">
                                        <a class="btn" href="{{ route('products') }}">{{ __('Shop Now') }}</a>
                                    </div>
                                </div>
                            </div>

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
                        <p>{{ __('There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">

                    <div class="single-category">
                        <h3 class="heading">{{ __('TV & Audios') }}</h3>
                        <ul>
                            <li><a href="{{ route('products') }}">{{ __('Smart Television') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('QLED TV') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Audios') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Headphones') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('View All') }}</a></li>
                        </ul>
                        <div class="images">
                            <img src="{{ asset('assets/frontend/images/featured-categories/fetured-item-1.png') }}"
                                alt="#">
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 col-12">

                    <div class="single-category">
                        <h3 class="heading">{{ __('Desktop & Laptop') }}</h3>
                        <ul>
                            <li><a href="{{ route('products') }}">{{ __('Smart Television') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('QLED TV') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Audios') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Headphones') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('View All') }}</a></li>
                        </ul>
                        <div class="images">
                            <img src="{{ asset('assets/frontend/images/featured-categories/fetured-item-2.png') }}"
                                alt="#">
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 col-12">

                    <div class="single-category">
                        <h3 class="heading">{{ __('Cctv Camera') }}</h3>
                        <ul>
                            <li><a href="{{ route('products') }}">{{ __('Smart Television') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('QLED TV') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Audios') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Headphones') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('View All') }}</a></li>
                        </ul>
                        <div class="images">
                            <img src="{{ asset('assets/frontend/images/featured-categories/fetured-item-3.png') }}"
                                alt="#">
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 col-12">

                    <div class="single-category">
                        <h3 class="heading">{{ __('Dslr Camera') }}</h3>
                        <ul>
                            <li><a href="{{ route('products') }}">{{ __('Smart Television') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('QLED TV') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Audios') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Headphones') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('View All') }}</a></li>
                        </ul>
                        <div class="images">
                            <img src="{{ asset('assets/frontend/images/featured-categories/fetured-item-4.png') }}"
                                alt="#">
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 col-12">

                    <div class="single-category">
                        <h3 class="heading">{{ __('Smart Phones') }}</h3>
                        <ul>
                            <li><a href="{{ route('products') }}">{{ __('Smart Television') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('QLED TV') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Audios') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Headphones') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('View All') }}</a></li>
                        </ul>
                        <div class="images">
                            <img src="{{ asset('assets/frontend/images/featured-categories/fetured-item-5.png') }}"
                                alt="#">
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 col-12">

                    <div class="single-category">
                        <h3 class="heading">{{ __('Game Console') }}</h3>
                        <ul>
                            <li><a href="{{ route('products') }}">{{ __('Smart Television') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('QLED TV') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Audios') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('Headphones') }}</a></li>
                            <li><a href="{{ route('products') }}">{{ __('View All') }}</a></li>
                        </ul>
                        <div class="images">
                            <img src="{{ asset('assets/frontend/images/featured-categories/fetured-item-6.png') }}"
                                alt="#">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{ __('Trending Product') }}</h2>
                        <p>{{ __('There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.') }}
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
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner custom-responsive-margin"
                        style="background-image:url('{{ asset('assets/frontend/images/banner/banner-2-bg.jpg') }}')">
                        <div class="content">
                            <h2>{{ __('Smart Headphone') }}</h2>
                            <p>{{ __('Lorem ipsum dolor sit amet,') }}
                                <br>{{ __('eiusmod tempor incididunt ut labore.') }}
                            </p>
                            <div class="button">
                                <a href="{{ route('products') }}" class="btn">{{ __('Shop Now') }}</a>
                            </div>
                        </div>
                    </div>
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
                        <p>{{ __('There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">

                            <div class="single-product">
                                <div class="product-image">
                                    <img src="{{ asset('assets/frontend/images/products/product-3.jpg') }}"
                                        alt="#">
                                    <div class="button">
                                        <a href="javascript:void(0)" class="btn"><i class="lni lni-cart"></i>
                                            {{ __('Add to Cart') }}</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <span class="category">{{ __('Camera') }}</span>
                                    <h4 class="title">
                                        <a href="{{ route('products') }}">{{ __('WiFi Security Camera') }}</a>
                                    </h4>
                                    <ul class="review">
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><span>{{ __('5.0 Review(s)') }}</span></li>
                                    </ul>
                                    <div class="price">
                                        <span>{{ __("৳ 399.00") }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 col-12">

                            <div class="single-product">
                                <div class="product-image">
                                    <img src="{{ asset('assets/frontend/images/products/product-8.jpg') }}"
                                        alt="#">
                                    <div class="button">
                                        <a href="javascript:void(0)" class="btn"><i class="lni lni-cart"></i>
                                            {{ __('Add to Cart') }}</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <span class="category">{{ __('Laptop') }}</span>
                                    <h4 class="title">
                                        <a href="{{ route('products') }}">{{ __('Apple MacBook Air') }}</a>
                                    </h4>
                                    <ul class="review">
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><span>{{ __('5.0 Review(s)') }}</span></li>
                                    </ul>
                                    <div class="price">
                                        <span>{{ __("৳ 899.00") }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 col-12">

                            <div class="single-product">
                                <div class="product-image">
                                    <img src="{{ asset('assets/frontend/images/products/product-6.jpg') }}"
                                        alt="#">
                                    <div class="button">
                                        <a href="javascript:void(0)" class="btn"><i class="lni lni-cart"></i>
                                            {{ __('Add to Cart') }}</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <span class="category">{{ __('Speaker') }}</span>
                                    <h4 class="title">
                                        <a href="{{ route('products') }}">{{ __('Bluetooth Speaker') }}</a>
                                    </h4>
                                    <ul class="review">
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star-filled"></i></li>
                                        <li><i class="lni lni-star"></i></li>
                                        <li><span>{{ __('4.0 Review(s)') }}</span></li>
                                    </ul>
                                    <div class="price">
                                        <span>{{ __("৳ 70.00") }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="single-banner right"
                        style="background-image:url('{{ asset('assets/frontend/images/banner/banner-3-bg.jpg') }}');margin-top: 30px;">
                        <div class="content">
                            <h2>{{ __('Samsung Notebook 9') }} </h2>
                            <p>{{ __('Lorem ipsum dolor sit amet,') }}
                                <br>{{ __('eiusmod tempor incididunt ut labore.') }}
                            </p>
                            <div class="price">
                                <span>{{ __("৳ 590.00") }}</span>
                            </div>
                            <div class="button">
                                <a href="{{ route('products') }}" class="btn">{{ __('Shop Now') }}</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="offer-content">
                        <div class="image">
                            <img src="{{ asset('assets/frontend/images/offer/offer-image.jpg') }}" alt="#">
                            <span class="sale-tag">{{ __('-50%') }}</span>
                        </div>
                        <div class="text">
                            <h2><a href="{{ route('products') }}">{{ __('Bluetooth Headphone') }}</a></h2>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><span>{{ __('5.0 Review(s)') }}</span></li>
                            </ul>
                            <div class="price">
                                <span>{{ __("৳ 200.00") }}</span>
                                <span class="discount-price">{{ __("৳ 400.00") }}</span>
                            </div>
                            <p>{{ __('Lorem Ipsum is simply dummy text of the printing and typesetting industry incididunt ut eiusmod tempor labores.') }}
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
                                <h2 id="secondstxt">{{ __('Secondes') }}</h2>
                            </div>
                        </div>
                        <div style="display: none;background: rgb(204, 24, 24);" class="alert offer-expired-alert">
                            <h1 style="padding: 50px 80px;color: white;">{{ __('We are sorry, Event ended !') }}
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-product-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">{{ __('Best Sellers') }}</h4>

                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/01.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('GoPro Hero4 Silver') }}</a>
                            </h3>
                            <span>{{ __("৳ 287.99") }}</span>
                        </div>
                    </div>


                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/02.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('Puro Sound Labs BT2200') }}</a>
                            </h3>
                            <span>{{ __("৳ 95.00") }}</span>
                        </div>
                    </div>


                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/03.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('HP OfficeJet Pro 8710') }}</a>
                            </h3>
                            <span>{{ __("৳ 120.00") }}</span>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">{{ __('New Arrivals') }}</h4>

                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/04.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('iPhone X 256 GB Space Gray') }}</a>
                            </h3>
                            <span>{{ __("৳ 1150.00") }}</span>
                        </div>
                    </div>


                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/05.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('Canon EOS M50 Mirrorless Camera') }}</a>
                            </h3>
                            <span>{{ __("৳ 950.00") }}</span>
                        </div>
                    </div>


                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/06.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('Microsoft Xbox One S') }}</a>
                            </h3>
                            <span>{{ __("৳ 298.00") }}</span>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <h4 class="list-title">{{ __('Top Rated') }}</h4>

                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/07.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('Samsung Gear 360 VR Camera') }}</a>
                            </h3>
                            <span>{{ __("৳ 68.00") }}</span>
                        </div>
                    </div>


                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/08.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('Samsung Galaxy S9+ 64 GB') }}</a>
                            </h3>
                            <span>{{ __("৳ 840.00") }}</span>
                        </div>
                    </div>


                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products') }}"><img
                                    src="{{ asset('assets/frontend/images/home-product-list/09.jpg') }}"
                                    alt="#"></a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products') }}">{{ __('Zeus Bluetooth Headphones') }}</a>
                            </h3>
                            <span>{{ __("৳ 28.00") }}</span>
                        </div>
                    </div>

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
                    <div class="brand-logo">
                        <img src="{{ asset('assets/frontend/images/brands/05.png') }}" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="{{ asset('assets/frontend/images/brands/06.png') }}" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="{{ asset('assets/frontend/images/brands/03.png') }}" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="{{ asset('assets/frontend/images/brands/04.png') }}" alt="#">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
