@extends('frontend.layouts.master')

@section('title')
    {{ __('Reset Password') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Reset Password') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li>{{ __('Reset Password') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="card-body">
                            <div class="title">
                                <h3>{{ __('Reset Password') }}</h3>
                                <p>{{ __('Choose a new password for your account.') }}</p>
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
                            <div class="form-group input-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    value="{{ old('email', $request->email) }}" required autofocus
                                    autocomplete="username">
                            </div>
                            <div class="form-group input-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="password" name="password" required
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group input-group">
                                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">{{ __('Reset Password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
