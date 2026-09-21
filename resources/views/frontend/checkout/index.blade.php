@extends('frontend.layouts.master')

@section('title')
    {{ __('Checkout') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">checkout</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{ route('products') }}">Shop</a></li>
                        <li>checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="checkout-steps-form-style-1">
                        <ul id="accordionExample">
                            <li>
                                <section class="checkout-steps-form-content"
                                    style="border-top-color: #e6e6e6; border-radius: 4px; padding-top: 25px;">
                                    @php
                                        $showOnline = old('payment_method', 'cash_on_delivery') === 'online';
                                    @endphp

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="btn-group w-100" role="group" aria-label="Payment method">
                                                <button type="button"
                                                    class="btn {{ $showOnline ? 'btn-outline-primary' : 'btn-primary' }} flex-fill"
                                                    id="btn-cash-on-delivery" onclick="showPaymentMethod('cod')">
                                                    {{ __('Cash on Delivery') }}
                                                </button>
                                                <button type="button"
                                                    class="btn {{ $showOnline ? 'btn-primary' : 'btn-outline-primary' }} flex-fill"
                                                    id="btn-online-payment" onclick="showPaymentMethod('online')">
                                                    {{ __('Online Payment') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger" id="checkout-validation-alert">
                                            <ul class="mb-0 mt-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    {{-- Cash on Delivery form --}}
                                    <div class="row {{ $showOnline ? 'd-none' : '' }}" id="payment-cod">
                                        <form action="{{ route('checkout.cod.store') }}" method="POST"
                                            onsubmit="document.getElementById('cod-confirm-btn').disabled = true;">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="cash_on_delivery">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Full Name') }}</label>
                                                        <div class="form-input form">
                                                            <input type="text" name="full_name"
                                                                placeholder="{{ __('Full Name') }}"
                                                                value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Email Address') }}</label>
                                                        <div class="form-input form">
                                                            <input type="email" name="email"
                                                                placeholder="{{ __('Email Address') }}"
                                                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Phone Number') }}</label>
                                                        <div class="form-input form">
                                                            <input type="text" name="phone"
                                                                placeholder="{{ __('Phone Number') }}"
                                                                value="{{ old('phone') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Delivery Address') }}</label>
                                                        <div class="form-input form">
                                                            <textarea name="delivery_address" rows="4" placeholder="{{ __('Delivery Address') }}" required>{{ old('delivery_address') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form form-default">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="cod_payment_option" id="cod-selected"
                                                                value="cash_on_delivery" checked>
                                                            <label class="form-check-label" for="cod-selected">
                                                                {{ __('Cash on Delivery') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="terms" id="cod-terms" value="1" required>
                                                            <label class="form-check-label" for="cod-terms">
                                                                {{ __('I accept terms and conditions') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form button">
                                                        <button type="submit" class="btn" id="cod-confirm-btn">
                                                            {{ __('Confirm Order') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Online Payment form --}}
                                    <div class="row {{ $showOnline ? '' : 'd-none' }}" id="payment-online">
                                        <form action="{{ route('checkout.online.store') }}" method="POST"
                                            onsubmit="document.getElementById('online-confirm-btn').disabled = true;">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="online">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Full Name') }}</label>
                                                        <div class="form-input form">
                                                            <input type="text" name="full_name"
                                                                placeholder="{{ __('Full Name') }}"
                                                                value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Email Address') }}</label>
                                                        <div class="form-input form">
                                                            <input type="email" name="email"
                                                                placeholder="{{ __('Email Address') }}"
                                                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Phone Number') }}</label>
                                                        <div class="form-input form">
                                                            <input type="text" name="phone"
                                                                placeholder="{{ __('Phone Number') }}"
                                                                value="{{ old('phone') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form form-default">
                                                        <label>{{ __('Delivery Address') }}</label>
                                                        <div class="form-input form">
                                                            <textarea name="delivery_address" rows="4" placeholder="{{ __('Delivery Address') }}" required>{{ old('delivery_address') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form form-default">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="cod_payment_option" id="online-selected"
                                                                value="online" checked>
                                                            <label class="form-check-label" for="online-selected">
                                                                {{ __('SSLCommerz (bKash, Nagad, Rocket, Cards, Internet Banking)') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="terms" id="online-terms" value="1" required>
                                                            <label class="form-check-label" for="online-terms">
                                                                {{ __('I accept terms and conditions') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form button">
                                                        <button type="submit" class="btn" id="online-confirm-btn">
                                                            {{ __('Pay Online') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-price-table mt-30">
                            <h5 class="title">{{ __('Your Order') }}</h5>
                            @forelse ($items as $hash => $item)
                                <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                    <a href="{{ route('products.show', $item->id) }}">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </a>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-semibold">
                                            <a href="{{ route('products.show', $item->id) }}">{{ $item->name }}</a>
                                        </p>
                                        <small class="text-muted">
                                            {{ $item->qty }} x ৳ {{ number_format($item->price, 2) }}
                                        </small>
                                    </div>
                                    <p class="mb-0 fw-semibold">৳ {{ number_format($item->subTotal(), 2) }}</p>
                                </div>
                            @empty
                                <p class="py-3 text-center">{{ __('Your cart is empty.') }}</p>
                            @endforelse

                            <div class="sub-total-price">
                                <div class="total-price">
                                    <p class="value">Subtotal Price:</p>
                                    <p class="price">৳ {{ number_format($subTotal, 2) }}</p>
                                </div>
                                <div class="total-price shipping">
                                    <p class="value">Shipping:</p>
                                    <p class="price">৳ {{ number_format($shipping, 2) }}</p>
                                </div>
                                <div class="total-price discount">
                                    <p class="value">Tax:</p>
                                    <p class="price">৳ {{ number_format($taxTotal, 2) }}</p>
                                </div>
                            </div>
                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Total Payable:</p>
                                    <p class="price">৳ {{ number_format($total, 2) }}</p>
                                </div>
                            </div>
                            <div class="price-table-btn button">
                                <a href="{{ route('cart.index') }}" class="btn btn-alt">{{ __('Back to Cart') }}</a>
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
        #payment-cod form>.row>div:first-child .single-form,
        #payment-online form>.row>div:first-child .single-form {
            margin-top: 0;
        }

        #payment-cod textarea[name="delivery_address"],
        #payment-online textarea[name="delivery_address"] {
            height: auto;
        }
    </style>
@endpush

@push('scripts')
    <script>
        @if ($errors->any())
            window.addEventListener('load', function () {
                const alertEl = document.getElementById('checkout-validation-alert');

                if (alertEl) {
                    alertEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        @endif

        function showPaymentMethod(method) {
            const codSection = document.getElementById('payment-cod');
            const onlineSection = document.getElementById('payment-online');
            const codBtn = document.getElementById('btn-cash-on-delivery');
            const onlineBtn = document.getElementById('btn-online-payment');

            if (method === 'cod') {
                codSection.classList.remove('d-none');
                onlineSection.classList.add('d-none');
                codBtn.classList.remove('btn-outline-primary');
                codBtn.classList.add('btn-primary');
                onlineBtn.classList.remove('btn-primary');
                onlineBtn.classList.add('btn-outline-primary');
            } else {
                onlineSection.classList.remove('d-none');
                codSection.classList.add('d-none');
                onlineBtn.classList.remove('btn-outline-primary');
                onlineBtn.classList.add('btn-primary');
                codBtn.classList.remove('btn-primary');
                codBtn.classList.add('btn-outline-primary');
            }
        }
    </script>
@endpush
