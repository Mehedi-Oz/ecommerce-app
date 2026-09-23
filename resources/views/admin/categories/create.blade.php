@extends('admin.layouts.master')

@section('title', 'Add Category')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Category</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new category</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Electronics" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Mobile phones, laptops and accessories" />

                        <x-admin.input-select name="is_featured" :label="__('Featured')" :selected="old('is_featured', '0')">
                            <option value="1" @selected(old('is_featured') === '1')>Yes</option>
                            <option value="0" @selected(old('is_featured', '0') === '0')>No</option>
                        </x-admin.input-select>

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