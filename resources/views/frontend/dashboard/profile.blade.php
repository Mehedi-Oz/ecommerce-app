@extends('frontend.layouts.master')

@section('title')
    {{ __('Profile Settings') }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{ __('Profile Settings') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                        <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li>{{ __('Profile') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    @include('frontend.dashboard.sidebar', ['active' => 'profile'])
                </div>
                <div class="col-lg-9 col-12">
                    <div class="checkout-steps-form-style-1">
                        <section class="checkout-steps-form-content" style="border-top-color: #e6e6e6; border-radius: 4px; padding-top: 25px;">
                            <h5 class="mb-3">{{ __('Profile Settings') }}</h5>
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
                            <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form form-default">
                                            <label>{{ __('Profile Photo') }}</label>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $photoUrl }}" alt="{{ $user->name }}"
                                                    class="dashboard-profile-photo">
                                                <div class="flex-grow-1">
                                                    <input type="file" name="photo" accept="image/*" class="form-control">
                                                    <small class="text-muted text-sm">{{ __('(JPG, PNG or WebP, max 2MB.)') }}</small>
                                                    @if ($user->image)
                                                        <div class="form-check mt-1">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="remove_photo" id="remove-photo" value="1">
                                                            <label class="form-check-label" for="remove-photo">
                                                                {{ __('Remove current photo') }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-form form-default">
                                            <label>{{ __('Full Name') }}</label>
                                            <div class="form-input form">
                                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-form form-default">
                                            <label>{{ __('Email Address') }}</label>
                                            <div class="form-input form">
                                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-form form-default">
                                            <label>{{ __('Phone Number') }}</label>
                                            <div class="form-input form">
                                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-form form-default">
                                            <label>{{ __('NID') }}</label>
                                            <div class="form-input form">
                                                <input type="text" name="nid" value="{{ old('nid', $user->nid) }}" placeholder="{{ __('National ID number') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-form form-default">
                                            <label>{{ __('Date of Birth') }}</label>
                                            <div class="form-input form">
                                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form form-default">
                                            <label>{{ __('Address') }}</label>
                                            <div class="form-input form">
                                                <textarea name="address" rows="3" placeholder="{{ __('Your address') }}">{{ old('address', $user->address) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form button">
                                            <button type="submit" class="btn">{{ __('Save Changes') }}</button>
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

@push('styles')
    <style>
        .dashboard-profile-photo {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
    </style>
@endpush
