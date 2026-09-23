@extends('admin.layouts.master')

@section('title', 'Add Hero Slider')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Hero Slider</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new slide</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.hero-sliders.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <x-admin.input-text name="subtitle" :label="__('Subtitle')" placeholder="e.g. Big Sale Offer" />
                        <x-admin.input-text name="title" :label="__('Title')" placeholder="e.g. M75 Sport Watch" />
                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Short slide description" />
                        <x-admin.input-text name="price_text" :label="__('Price Text')" placeholder="e.g. ৳ 320.99" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="button_text" :label="__('Button Text')" placeholder="e.g. Shop Now" />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-text name="button_url" :label="__('Button URL')" placeholder="e.g. /products" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Background Image</label>
                            <div class="@error('background_image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="background_image" />
                            </div>
                            <x-admin.input-error :for="'background_image'" />
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
                            <x-admin.submit-button :label="__('Create Slider')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
