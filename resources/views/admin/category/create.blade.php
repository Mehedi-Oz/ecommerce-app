@extends('admin.layouts.master')

@section('title', 'Add Category')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Category</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new category</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.category.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Electronics" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Mobile phones, laptops and accessories" />

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="dropify" name="image" />
                            <x-admin.input-error :for="'image'" />
                        </div>

                        <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', 'published')">
                            <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status') === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Create Category')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection