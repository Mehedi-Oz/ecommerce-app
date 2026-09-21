@extends('frontend.layouts.master')

@section('title')
    {{ __('Cart') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Cart</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{ route('products') }}">Shop</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">

                <div class="cart-list-title d-none d-md-block">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Price</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12 text-center">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>


                @forelse ($items as $hash => $item)
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            {{-- Product image --}}
                            <div class="col-lg-1 col-md-1 col-3">
                                <a href="{{ route('products.show', $item->id) }}"><img
                                        src="{{ $item->image }}"
                                        alt="{{ $item->name }}"></a>
                            </div>
                            {{-- Product name --}}
                            <div class="col-lg-3 col-md-3 col-9 text-start">
                                <h5 class="product-name"><a href="{{ route('products.show', $item->id) }}">
                                        {{ $item->name }}</a></h5>
                                <p class="d-md-none mb-0 cart-mobile-price">৳ {{ number_format($item->price, 2) }}</p>
                            </div>

                            {{-- Desktop-only price column --}}
                            <div class="col-lg-2 col-md-2 d-none d-md-block">
                                <p class="mb-0">৳ {{ number_format($item->price, 2) }}</p>
                            </div>

                            {{-- Quantity --}}
                            <div class="col-lg-2 col-md-2 col-4 mt-3 mt-md-0">
                                <span class="cart-mobile-label d-md-none">Qty</span>
                                <div class="count-input">
                                    <form action="{{ route('cart.update', $hash) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select class="form-control" name="quantity" onchange="this.form.submit()">
                                            @for ($i = 1; $i <= min(10, max($item->qty, 10)); $i++)
                                                <option value="{{ $i }}" @selected($item->qty == $i)>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </form>
                                </div>
                            </div>

                            {{-- Subtotal --}}
                            <div class="col-lg-2 col-md-2 col-6 mt-3 mt-md-0 text-center text-md-start">
                                <span class="cart-mobile-label d-md-none">Subtotal</span>
                                <p class="mb-0">৳ {{ number_format($item->subtotal(), 2) }}</p>
                            </div>

                            {{-- Remove button --}}
                            <div class="col-lg-2 col-md-2 col-2 mt-3 mt-md-0 d-flex flex-column align-items-end align-items-md-center justify-content-center">
                                <span class="cart-mobile-label d-md-none invisible">&nbsp;</span>
                                <form action="{{ route('cart.destroy', $hash) }}" method="POST" class="d-flex justify-content-center align-items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-item"
                                        style="border: 0; padding: 0; cursor: pointer;"><i
                                            class="lni lni-close"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-12 text-center py-4">
                                <p>{{ __('Your cart is empty.') }}</p>
                                <div class="button d-flex justify-content-center mt-2">
                                    <a href="{{ route('products') }}" class="btn">{{ __('Continue shopping') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse

            </div>
            @if (count($items) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end mt-3 mb-3">
                            <div class="button mb-0">
                                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-alt">{{ __('Clear cart') }}</button>
                                </form>
                            </div>
                        </div>

                        <div class="total-amount">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="right">
                                        <ul>
                                            <li>Cart Subtotal<span>৳ {{ number_format($subTotal, 2) }}</span></li>
                                            <li>Tax (15%)<span>৳ {{ number_format($taxTotal, 2) }}</span></li>
                                            <li>Shipping<span>৳ {{ number_format($shipping, 2) }}</span></li>
                                            <li class="last">You Pay<span>৳ {{ number_format($total, 2) }}</span></li>
                                        </ul>
                                        <div class="button">
                                            <a href="{{ route('checkout') }}" class="btn">Checkout</a>
                                            <a href="{{ route('products') }}" class="btn btn-alt">Continue shopping</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
