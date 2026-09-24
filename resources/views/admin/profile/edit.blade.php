@extends('admin.layouts.master')

@section('title', 'My Profile')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">My Profile</h4>
                    <h6 class="card-subtitle">Update your name, email and image</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            @if ($admin->image)
                                <x-admin.image-preview :src="$admin->image" class="mb-2" />
                            @endif
                            <div class="@error('image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="image"
                                    data-default-file="{{ $admin->image ? asset($admin->image) : '' }}" />
                            </div>
                            <x-admin.input-error :for="'image'" />
                        </div>

                        <x-admin.input-text name="name" :label="__('Name')" :value="$admin->name" required />

                        <x-admin.input-text type="email" name="email" :label="__('Email')" :value="$admin->email" required />

                        <div class="mt-3 d-flex gap-2">
                            <x-admin.submit-button :label="__('Save Changes')" />
                            <a href="{{ route('admin.password.edit') }}" class="btn btn-info waves-effect waves-light text-white">Change Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
