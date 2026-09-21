@extends('frontend.layouts.master')

@section('title')
    {{ __('Change Password') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Change Password') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li>{{ __('Password') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    @include('frontend.dashboard.sidebar', ['active' => 'password'])
                </div>
                <div class="col-lg-9 col-12">
                    <div class="checkout-steps-form-style-1">
                        <section class="checkout-steps-form-content" style="border-top-color: #e6e6e6; border-radius: 4px; padding-top: 25px;">
                            <h5 class="mb-3">{{ __('Change Password') }}</h5>
                            @session('status')
                                <div class="alert alert-success">{{ $value }}</div>
                            @endsession
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('dashboard.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form form-default">
                                            <label>{{ __('Current Password') }}</label>
                                            <div class="form-input form">
                                                <input type="password" name="current_password" required autocomplete="current-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-form form-default">
                                            <label>{{ __('New Password') }}</label>
                                            <div class="form-input form">
                                                <input type="password" name="password" required autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-form form-default">
                                            <label>{{ __('Confirm New Password') }}</label>
                                            <div class="form-input form">
                                                <input type="password" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form button">
                                            <button type="submit" class="btn">{{ __('Update Password') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
