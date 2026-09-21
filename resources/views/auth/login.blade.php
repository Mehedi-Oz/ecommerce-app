@extends('frontend.layouts.master')

@section('title')
    {{ __('Login') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Login') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li>{{ __('Login') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>{{ __('Login Now') }}</h3>
                                <p>{{ __('Welcome back! Login with your email address and password.') }}</p>
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
                            <div class="form-group input-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="password" name="password" required
                                    autocomplete="current-password">
                            </div>
                            <div class="d-flex flex-wrap justify-content-between bottom-content">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input width-auto" id="remember_me"
                                        name="remember">
                                    <label class="form-check-label">{{ __('Remember me') }}</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="lost-pass"
                                        href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                                @endif
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">{{ __('Login') }}</button>
                            </div>
                            <p class="outer-link">{{ __("Don't have an account?") }} <a
                                    href="{{ route('register') }}">{{ __('Register here') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
