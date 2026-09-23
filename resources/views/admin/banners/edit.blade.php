@extends('admin.layouts.master')

@section('title', 'Update Banner')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Banner</h4>
                    <h6 class="card-subtitle">Edit the details below to update the banner</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-admin.input-select name="location" :label="__('Location')" :selected="old('location', $banner->location)">
                            @foreach ($locations as $location)
                                <option value="{{ $location }}" @selected(old('location', $banner->location) === $location)>{{ ucwords(str_replace('_', ' ', $location)) }}</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-text name="title" :label="__('Title')" :value="$banner->title" />
                        <x-admin.input-text-area name="description" :label="__('Description')" :value="$banner->description" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="button_text" :label="__('Button Text')" :value="$banner->button_text" />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-text name="button_url" :label="__('Button URL')" :value="$banner->button_url" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            @if ($banner->image)
                                <x-admin.image-preview :src="$banner->image" class="mb-2" />
                            @endif
                            <div class="@error('image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="image"
                                    data-default-file="{{ $banner->image ? asset($banner->image) : '' }}" />
                            </div>
                            <x-admin.input-error :for="'image'" />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="sort_order" type="number" :label="__('Sort Order')" :value="$banner->sort_order" />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="is_active" :label="__('Active')" :selected="old('is_active', (string) $banner->is_active)">
                                    <option value="1" @selected(old('is_active', (string) $banner->is_active) === '1')>Yes</option>
                                    <option value="0" @selected(old('is_active', (string) $banner->is_active) === '0')>No</option>
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Banner')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
