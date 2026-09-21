@extends('frontend.layouts.master')

@section('title')
    {{ __('Order Completed') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Order Completed') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li>{{ __('Order Completed') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2>{{ __('Thank you for your order!') }}</h2>
                    @if (! empty($order) && $order->payment_type === 'online' && $order->payment_status === 'paid')
                        <p class="my-3">{{ __('Payment successful! Your order has been placed successfully.') }}</p>
                    @elseif (! empty($order) && $order->payment_type === 'online')
                        <p class="my-3">{{ __('Thank you for your order!') }}</p>
                    @else
                        <p class="my-3">{{ __('Your order has been placed successfully with cash on delivery.') }}</p>
                    @endif
                    <div class="button">
                        <a href="{{ route('products') }}" class="btn">{{ __('Continue Shopping') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
