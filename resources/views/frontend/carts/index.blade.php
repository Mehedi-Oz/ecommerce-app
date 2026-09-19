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

                <div class="cart-list-title">
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
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>


                @forelse ($items as $hash => $item)
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="{{ route('products.show', $item->id) }}"><img
                                        src="{{ $item->image }}"
                                        alt="{{ $item->name }}"></a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <h5 class="product-name"><a href="{{ route('products.show', $item->id) }}">
                                        {{ $item->name }}</a></h5>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>৳ {{ number_format($item->price, 2) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
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
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>৳ {{ number_format($item->subTotal(), 2) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <form action="{{ route('cart.destroy', $hash) }}" method="POST">
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
                                <a href="{{ route('products') }}" class="btn mt-2">{{ __('Continue shopping') }}</a>
                            </div>
                        </div>
                    </div>
                @endforelse

            </div>
            @if (count($items) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end mb-3">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-alt">{{ __('Clear cart') }}</button>
                            </form>
                        </div>

                        <div class="total-amount">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-12">
                                    <div class="left">
                                        <div class="coupon">
                                            <form action="#" target="_blank">
                                                <input name="Coupon" placeholder="Enter Your Coupon">
                                                <div class="button">
                                                    <button class="btn">Apply Coupon</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
