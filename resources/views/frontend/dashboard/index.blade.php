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
                    <div class="checkout-sidebar-price-table mt-0 mb-4">
                        <div class="button d-flex align-items-center gap-3">
                            @if ($user->image)
                                <img src="{{ $photoUrl }}" alt="{{ $user->name }}" class="dashboard-avatar-img">
                            @else
                                <span class="dashboard-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                            @endif
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ __('Hello, :name', ['name' => $user->name]) }}</h5>
                                <p class="mb-0 text-muted">
                                    {{ $user->email }} &middot; {{ __('Member since :date', ['date' => $user->created_at->format('M Y')]) }}
                                </p>
                            </div>
                            <a href="{{ route('dashboard.profile') }}" class="btn btn-alt btn-sm text-nowrap">{{ __('Edit Profile') }}</a>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-lg-12 col-12 mb-4 mb-lg-0">
                            <div class="checkout-sidebar-price-table mt-0 h-100">
                                <h5 class="title">{{ __('Recent Orders') }}</h5>
                                @forelse ($recentOrders as $order)
                                    <div class="d-flex align-items-center justify-content-between gap-2 py-2 border-bottom">
                                        <div>
                                            <p class="mb-0 fw-semibold">
                                                <a href="{{ route('dashboard.orders.show', $order) }}">{{ __('Order #:id', ['id' => $orderNumbers[$order->id] ?? $order->id]) }}</a>
                                            </p>
                                            <small class="text-muted">{{ $order->created_at->format('d M Y') }} &middot; {{ $order->items_count }} {{ __('items') }} &middot; {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</small>
                                            <div class="mt-1">
                                                @if ($order->order_status === 'completed')
                                                    <span class="badge bg-success">{{ __('Completed') }}</span>
                                                @elseif ($order->order_status === 'processing')
                                                    <span class="badge bg-info">{{ __('Processing') }}</span>
                                                @elseif ($order->order_status === 'cancelled')
                                                    <span class="badge bg-danger">{{ __('Cancelled') }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                                @endif
                                                @if ($order->payment_status === 'paid')
                                                    <span class="badge bg-success">{{ __('Paid') }}</span>
                                                @elseif ($order->payment_status === 'failed')
                                                    <span class="badge bg-danger">{{ __('Failed') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ __('Unpaid') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-0 fw-semibold">৳ {{ number_format($order->order_total, 2) }}</p>
                                            <a href="{{ route('dashboard.orders.show', $order) }}" class="small">{{ __('View') }}</a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="py-3 text-center mb-0">{{ __('You have not placed any orders yet.') }}</p>
                                    <div class="button text-center pb-3">
                                        <a href="{{ route('products') }}" class="btn btn-sm">{{ __('Continue Shopping') }}</a>
                                    </div>
                                @endforelse
                                @if ($recentOrders->isNotEmpty())
                                    <div class="price-table-btn button mt-3 text-center">
                                        <a href="{{ route('dashboard.orders') }}" class="btn btn-alt">{{ __('View All Orders') }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .dashboard-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #0167f3;
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dashboard-avatar-img {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
    </style>
@endpush
