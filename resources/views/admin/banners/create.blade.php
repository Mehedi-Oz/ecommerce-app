@extends('admin.layouts.master')

@section('title', 'Add Banner')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Banner</h4>
                    <h6 class="card-subtitle">Pick a location, then fill in the content</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.banners.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <x-admin.input-select name="location" :label="__('Location')" :selected="old('location')">
                            @foreach ($locations as $location)
                                <option value="{{ $location }}" @selected(old('location') === $location)>{{ ucwords(str_replace('_', ' ', $location)) }}</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-text name="title" :label="__('Title')" placeholder="e.g. Smart Watch 2.0" />
                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Short banner text" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="button_text" :label="__('Button Text')" placeholder="e.g. Shop Now" />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-text name="button_url" :label="__('Button URL')" placeholder="e.g. /products" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <div class="@error('image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="image" />
                            </div>
                            <x-admin.input-error :for="'image'" />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="sort_order" type="number" :label="__('Sort Order')" value="0" />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="is_active" :label="__('Active')" :selected="old('is_active', '1')">
                                    <option value="1" @selected(old('is_active', '1') === '1')>Yes</option>
                                    <option value="0" @selected(old('is_active') === '0')>No</option>
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Create Banner')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
