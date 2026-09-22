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
                        <div class="button order-filter-btns d-flex flex-wrap gap-2 mb-3">
                            <a href="{{ route('dashboard.orders') }}"
                                class="btn btn-sm {{ $statusFilter === null ? '' : 'btn-alt' }}">{{ __('All') }}</a>
                            @foreach ($statusOptions as $option)
                                <a href="{{ route('dashboard.orders', ['status' => $option]) }}"
                                    class="btn btn-sm {{ $statusFilter === $option ? '' : 'btn-alt' }}">{{ ucfirst($option) }}</a>
                            @endforeach
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Order') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Items') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Payment Type') }}</th>
                                        <th>{{ __('Payment Status') }}</th>
                                        <th>{{ __('Order Status') }}</th>
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
                                            <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                            <td>
                                                @if ($order->payment_status === 'paid')
                                                    <span class="badge bg-success">{{ __('Paid') }}</span>
                                                @elseif ($order->payment_status === 'failed')
                                                    <span class="badge bg-danger">{{ __('Failed') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ __('Unpaid') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->order_status === 'completed')
                                                    <span class="badge bg-success">{{ __('Completed') }}</span>
                                                @elseif ($order->order_status === 'processing')
                                                    <span class="badge bg-info">{{ __('Processing') }}</span>
                                                @elseif ($order->order_status === 'cancelled')
                                                    <span class="badge bg-danger">{{ __('Cancelled') }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('dashboard.orders.show', $order) }}">{{ __('View') }}</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 button">
                                                <p class="mb-2">{{ __('You have not placed any orders yet.') }}</p>
                                                <a href="{{ route('products') }}" class="btn btn-sm">{{ __('Shop Now') }}</a>
                                            </td>
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

@push('styles')
    <style>
        .order-filter-btns .btn {
            padding: 6px 14px;
            font-size: 13px;
            margin-right: 0;
        }
    </style>
@endpush
