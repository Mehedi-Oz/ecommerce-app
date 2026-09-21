@extends('frontend.layouts.master')

@section('title')
    {{ __('Registration') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Registration') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li>{{ __('Registration') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div class="register-form">
                        <div class="title">
                            <h3>{{ __('No Account? Register') }}</h3>
                            <p>{{ __('Registration takes less than a minute but gives you full control over your orders.') }}</p>
                        </div>
                        <form class="row" method="POST" action="{{ route('register') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="col-12">
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">{{ __('Full Name') }}</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ old('name') }}" required autofocus autocomplete="name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">{{ __('E-mail Address') }}</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ old('email') }}" required autocomplete="username">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">{{ __('Phone Number') }}</label>
                                    <input class="form-control" type="text" id="phone" name="phone"
                                        value="{{ old('phone') }}" required autocomplete="tel">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input class="form-control" type="password" id="password" name="password" required
                                        autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input class="form-control" type="password" id="password_confirmation"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">{{ __('Register') }}</button>
                            </div>
                            <p class="outer-link">{{ __('Already have an account?') }} <a
                                    href="{{ route('login') }}">{{ __('Login Now') }}</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
