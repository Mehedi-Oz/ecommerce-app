@extends('admin.layouts.master')

@section('title', 'Update Hero Slider')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Hero Slider</h4>
                    <h6 class="card-subtitle">Edit the details below to update the slide</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.hero-sliders.update', $slider) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-admin.input-text name="subtitle" :label="__('Subtitle')" :value="$slider->subtitle" />
                        <x-admin.input-text name="title" :label="__('Title')" :value="$slider->title" />
                        <x-admin.input-text-area name="description" :label="__('Description')" :value="$slider->description" />
                        <x-admin.input-text name="price_text" :label="__('Price Text')" :value="$slider->price_text" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="button_text" :label="__('Button Text')" :value="$slider->button_text" />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-text name="button_url" :label="__('Button URL')" :value="$slider->button_url" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Background Image</label>
                            @if ($slider->background_image)
                                <x-admin.image-preview :src="$slider->background_image" class="mb-2" />
                            @endif
                            <div class="@error('background_image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="background_image"
                                    data-default-file="{{ $slider->background_image ? asset($slider->background_image) : '' }}" />
                            </div>
                            <x-admin.input-error :for="'background_image'" />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="sort_order" type="number" :label="__('Sort Order')" :value="$slider->sort_order" />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="is_active" :label="__('Active')" :selected="old('is_active', (string) $slider->is_active)">
                                    <option value="1" @selected(old('is_active', (string) $slider->is_active) === '1')>Yes</option>
                                    <option value="0" @selected(old('is_active', (string) $slider->is_active) === '0')>No</option>
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Slider')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
