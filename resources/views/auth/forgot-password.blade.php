@extends('frontend.layouts.master')

@section('title')
    {{ __('Forgot Password') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Forgot Password') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li>{{ __('Forgot Password') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>{{ __('Reset Password') }}</h3>
                                <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @session('status')
                                <div class="alert alert-success">
                                    {{ $value }}
                                </div>
                            @endsession
                            <div class="form-group input-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    value="{{ old('email') }}" required autofocus autocomplete="username">
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">{{ __('Email Password Reset Link') }}</button>
                            </div>
                            <p class="outer-link"><a
                                    href="{{ route('login') }}">{{ __('Back to login') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
