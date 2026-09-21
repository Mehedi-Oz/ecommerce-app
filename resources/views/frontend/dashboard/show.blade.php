@extends('frontend.layouts.master')

@section('title')
    {{ __('Order #:id', ['id' => $orderNumber]) }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Order #:id', ['id' => $orderNumber]) }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('dashboard.orders') }}">{{ __('Orders') }}</a></li>
                        <li>#{{ $orderNumber }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    @include('frontend.dashboard.sidebar', ['active' => 'orders'])
                </div>
                <div class="col-lg-9 col-12">
                    <div class="checkout-sidebar-price-table mb-4">
                        <h5 class="title">{{ __('Order Info') }}</h5>
                        <div class="sub-total-price order-info">
                            <div class="total-price">
                                <p class="value">{{ __('Date') }}</p>
                                <p class="price">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div class="total-price">
                                <p class="value">{{ __('Order Status') }}</p>
                                <p class="price">{{ ucfirst($order->order_status) }}</p>
                            </div>
                            <div class="total-price">
                                <p class="value">{{ __('Payment') }}</p>
                                <p class="price">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }} ({{ ucfirst($order->payment_status) }})</p>
                            </div>
                            <div class="total-price">
                                <p class="value">{{ __('Delivery Status') }}</p>
                                <p class="price">{{ ucfirst($order->delivery_status) }}</p>
                            </div>
                            <div class="total-price">
                                <p class="value">{{ __('Delivery Address') }}</p>
                                <p class="price">{{ $order->delivery_address }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-sidebar-price-table">
                        <h5 class="title">{{ __('Order Items') }}</h5>
                        @foreach ($order->details as $detail)
                            <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold">{{ $detail->product_name }}</p>
                                    <small class="text-muted">{{ $detail->product_quantity }} x ৳ {{ number_format($detail->product_price, 2) }}</small>
                                </div>
                                <p class="mb-0 fw-semibold">৳ {{ number_format($detail->product_price * $detail->product_quantity, 2) }}</p>
                            </div>
                        @endforeach
                        <div class="sub-total-price">
                            <div class="total-price">
                                <p class="value">{{ __('Tax') }}</p>
                                <p class="price">৳ {{ number_format($order->tax_total, 2) }}</p>
                            </div>
                            <div class="total-price shipping">
                                <p class="value">{{ __('Shipping') }}</p>
                                <p class="price">৳ {{ number_format($order->shipping_total, 2) }}</p>
                            </div>
                        </div>
                        <div class="total-payable">
                            <div class="payable-price">
                                <p class="value">{{ __('Total') }}</p>
                                <p class="price">৳ {{ number_format($order->order_total, 2) }}</p>
                            </div>
                        </div>
                        <div class="price-table-btn button">
                            <a href="{{ route('dashboard.orders') }}" class="btn btn-alt">{{ __('Back to Orders') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
