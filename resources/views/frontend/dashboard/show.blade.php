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
                    @if ($order->order_status === 'cancelled')
                        <div class="alert alert-danger">{{ __('This order has been cancelled.') }}</div>
                    @elseif ($order->delivery_status === 'returned')
                        <div class="alert alert-warning">{{ __('This order has been returned.') }}</div>
                    @else
                        @php
                            $timelineDone = [
                                'placed' => true,
                                'processing' => in_array($order->order_status, ['processing', 'completed'], true) || $order->delivery_status !== 'pending',
                                'shipped' => in_array($order->delivery_status, ['shipped', 'delivered'], true),
                                'delivered' => $order->delivery_status === 'delivered',
                            ];
                            $timelineSteps = [
                                'placed' => __('Order Placed'),
                                'processing' => __('Processing'),
                                'shipped' => __('Shipped'),
                                'delivered' => __('Delivered'),
                            ];
                        @endphp
                        <div class="checkout-sidebar-price-table mt-0 mb-4">
                            <h5 class="title">{{ __('Order Progress') }}</h5>
                            <ol class="order-timeline">
                                @foreach ($timelineSteps as $key => $label)
                                    <li class="{{ $timelineDone[$key] ? 'done' : '' }}">
                                        <span class="order-timeline-dot"></span>
                                        <span>{{ $label }}</span>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-12 mb-4">
                            <div class="checkout-sidebar-price-table mt-0 h-100">
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
                                        <p class="value">{{ __('Delivery Status') }}</p>
                                        <p class="price">{{ ucfirst($order->delivery_status) }}</p>
                                    </div>
                                    <div class="total-price">
                                        <p class="value">{{ __('Items') }}</p>
                                        <p class="price">{{ $order->details->sum('product_quantity') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-4">
                            <div class="checkout-sidebar-price-table mt-0 h-100">
                                <h5 class="title">{{ __('Payment & Delivery') }}</h5>
                                <div class="sub-total-price order-info">
                                    <div class="total-price">
                                        <p class="value">{{ __('Payment') }}</p>
                                        <p class="price">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }} ({{ ucfirst($order->payment_status) }})</p>
                                    </div>
                                    <div class="total-price">
                                        <p class="value">{{ __('Transaction ID') }}</p>
                                        <p class="price">{{ $order->transaction_id ?: '—' }}</p>
                                    </div>
                                    <div class="total-price">
                                        <p class="value">{{ __('Delivery Address') }}</p>
                                        <p class="price">{{ $order->delivery_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($updateNotes->isNotEmpty())
                        <div class="checkout-sidebar-price-table mb-4">
                            <h5 class="title">{{ __('Store Updates') }}</h5>
                            @foreach ($updateNotes as $group)
                                <div class="py-2 {{ $loop->last ? '' : 'border-bottom' }}">
                                    <p class="mb-1">
                                        <span class="fw-semibold">{{ $group->first()->note }}</span>
                                    </p>
                                    <small class="text-muted d-block mb-1">{{ $group->first()->created_at->format('d M Y, h:i A') }}</small>
                                    @foreach ($group as $history)
                                        <small class="text-muted d-block">
                                            {{ ucfirst(str_replace('_', ' ', $history->field)) }}:
                                            {{ $history->old_value ?? '—' }} &rarr; {{ $history->new_value ?? '—' }}
                                        </small>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
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

@push('styles')
    <style>
        .order-timeline {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .order-timeline li {
            flex: 1;
            text-align: center;
            font-size: 13px;
            color: #888;
            position: relative;
            padding-top: 26px;
        }

        .order-timeline li::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e6e6e6;
        }

        .order-timeline li:first-child::before {
            left: 50%;
        }

        .order-timeline li:last-child::before {
            right: 50%;
        }

        .order-timeline-dot {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #ccc;
            z-index: 1;
        }

        .order-timeline li.done {
            color: #0167f3;
            font-weight: 600;
        }

        .order-timeline li.done .order-timeline-dot {
            border-color: #0167f3;
            background: #0167f3;
        }
    </style>
@endpush
