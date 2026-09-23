@extends('admin.layouts.master')

@section('title', 'Add Brand')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Brand</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new brand</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.brands.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Apple" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Premium consumer electronics and software" />

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <div class="@error('image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="image" />
                            </div>
                            <x-admin.input-error :for="'image'" />
                        </div>

                        <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', 'published')">
                            <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status') === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <x-admin.input-select name="is_featured" :label="__('Featured')" :selected="old('is_featured', '0')">
                            <option value="1" @selected(old('is_featured') === '1')>Yes</option>
                            <option value="0" @selected(old('is_featured', '0') === '0')>No</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Create Brand')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection