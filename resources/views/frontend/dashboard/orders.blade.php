@extends('frontend.layouts.master')

@section('title')
    {{ __('My Orders') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('My Orders') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li>{{ __('Orders') }}</li>
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
                    <div class="checkout-sidebar-price-table mt-0">
                        <h5 class="title">{{ __('My Orders') }}</h5>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Order') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Items') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td class="fw-semibold">#{{ $orderNumbers[$order->id] ?? $order->id }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>{{ $order->items_count }}</td>
                                            <td>৳ {{ number_format($order->order_total, 2) }}</td>
                                            <td>{{ ucfirst($order->order_status) }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('dashboard.orders.show', $order) }}">{{ __('View') }}</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">{{ __('You have not placed any orders yet.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($orders->hasPages())
                            <div class="pagination left mt-3">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
