@extends('frontend.layouts.master')

@section('title')
    {{ $product->name }}
@endsection


@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ $product->name }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{ route('products') }}">Shop</a></li>
                        <li>{{ $product->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            @php
                                $mainImage = $product->featured_image
                                    ? asset($product->featured_image)
                                    : null;
                            @endphp
                            <div class="xzoom-container">
                                @if ($mainImage)
                                    <img class="xzoom" id="xzoom-default" src="{{ $mainImage }}"
                                        xoriginal="{{ $mainImage }}" alt="{{ $product->name }}">
                                @endif
                                <div class="xzoom-thumbs">
                                    @if ($mainImage)
                                        <a href="{{ $mainImage }}">
                                            <img class="xzoom-gallery" width="80" src="{{ $mainImage }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                        </a>
                                    @endif
                                    @foreach ($product->images as $image)
                                        <a href="{{ asset($image->image_path) }}">
                                            <img class="xzoom-gallery" width="80" src="{{ asset($image->image_path) }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">{{ $product->name }}</h2>
                            @if ($product->category)
                                <p class="category"><i class="lni lni-tag"></i> {{ __('Category:') }} <a
                                        href="{{ route('products', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
                                </p>
                            @endif
                            @if ($product->subCategory)
                                <p class="category"><i class="lni lni-tag"></i> {{ __('SubCategory:') }} <a
                                        href="{{ route('products', ['category' => $product->category_id, 'subcategory' => $product->sub_category_id]) }}">{{ $product->subCategory->name }}</a>
                                </p>
                            @endif
                            @if ($product->brand)
                                <p class="category"><i class="lni lni-tag"></i> {{ __('Brand:') }}
                                    {{ $product->brand->name }}</p>
                            @endif
                            <p class="category"><i class="lni lni-tag"></i> {{ __('Stock:') }}
                                @if ($product->stock_amount > 0)
                                    {{ __(':count items available', ['count' => $product->stock_amount]) }}
                                @else
                                    {{ __('Out of stock') }}
                                @endif
                            </p>
                            <h3 class="price">৳ {{ number_format($product->selling_amount, 2) }}@if ($product->regular_amount > $product->selling_amount)
                                    <span>৳ {{ number_format($product->regular_amount, 2) }}</span>
                                @endif
                            </h3>
                            @if ($product->short_description)
                                <p class="info-text">{{ $product->short_description }}</p>
                            @endif
                            @if ($product->stock_amount > 0)
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="form-group quantity">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                    value="1" min="1" max="{{ $product->stock_amount }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bottom-content">
                                        <div class="row align-items-end">
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="button cart-button">
                                                    <button type="submit" class="btn"
                                                        style="width: 100%;">{{ __('Add to Cart') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="button cart-button">
                                                <button type="button" class="btn" style="width: 100%;"
                                                    disabled>{{ __('Stock Out') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>Details</h4>
                                @if ($product->long_description)
                                    <p>{{ $product->long_description }}</p>
                                @elseif ($product->short_description)
                                    <p>{{ $product->short_description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-name">Your Name</label>
                                <input class="form-control" type="text" id="review-name" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-email">Your Email</label>
                                <input class="form-control" type="email" id="review-email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-subject">Subject</label>
                                <input class="form-control" type="text" id="review-subject" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="review-rating">Rating</label>
                                <select class="form-control" id="review-rating">
                                    <option>5 Stars</option>
                                    <option>4 Stars</option>
                                    <option>3 Stars</option>
                                    <option>2 Stars</option>
                                    <option>1 Star</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review-message">Review</label>
                        <textarea class="form-control" id="review-message" rows="8" required></textarea>
                    </div>
                </div>
                <div class="modal-footer button">
                    <button type="button" class="btn">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/xzoom.css') }}" />
    <style>
        .item-details .product-images .xzoom-thumbs img {
            width: 80px;
        }

        .xzoom-preview {
            background: #fff !important;
        }

        .xzoom-preview img {
            background: #fff !important;
        }

        .xzoom-lens {
            background: #fff;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/xzoom.min.js') }}"></script>
    <script>
        (function($) {
            $(document).ready(function() {
                $('.xzoom, .xzoom-gallery').xzoom({
                    zoomWidth: 400,
                    title: false,
                    // tint: '#333',
                    Xoffset: 15,
                });
            });
        })(jQuery);
    </script>
@endpush
