@extends('frontend.layouts.master')

@section('title')
    {{ __('My Account') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('My Account') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li>{{ __('Dashboard') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    @include('frontend.dashboard.sidebar', ['active' => 'overview'])
                </div>
                <div class="col-lg-9 col-12">
                    <div class="row mb-4">
                        <div class="col-md-4 col-12">
                            <div class="checkout-sidebar-price-table mt-0 text-center">
                                <h5 class="title">{{ __('Total Orders') }}</h5>
                                <p class="price mb-0">{{ $totalOrders }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="checkout-sidebar-price-table mt-0 text-center">
                                <h5 class="title">{{ __('Pending Orders') }}</h5>
                                <p class="price mb-0">{{ $pendingOrders }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="checkout-sidebar-price-table mt-0 text-center">
                                <h5 class="title">{{ __('Total Spent') }}</h5>
                                <p class="price mb-0">৳ {{ number_format($totalSpent, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-sidebar-price-table mt-0">
                        <h5 class="title">{{ __('Recent Orders') }}</h5>
                        @forelse ($recentOrders as $order)
                            <div class="d-flex align-items-center justify-content-between gap-2 py-2 border-bottom">
                                <div>
                                    <p class="mb-0 fw-semibold">
                                        <a href="{{ route('dashboard.orders.show', $order) }}">{{ __('Order #:id', ['id' => $orderNumbers[$order->id] ?? $order->id]) }}</a>
                                    </p>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y') }} &middot; {{ $order->items_count }} {{ __('items') }}</small>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-semibold">৳ {{ number_format($order->order_total, 2) }}</p>
                                    <small class="text-muted">{{ ucfirst($order->order_status) }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="py-3 text-center mb-0">{{ __('You have not placed any orders yet.') }}</p>
                        @endforelse
                        @if ($recentOrders->isNotEmpty())
                            <div class="price-table-btn button mt-3">
                                <a href="{{ route('dashboard.orders') }}" class="btn btn-alt">{{ __('View All Orders') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
