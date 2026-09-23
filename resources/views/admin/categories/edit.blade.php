@extends('admin.layouts.master')

@section('title', 'Update Category')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Category</h4>
                    <h6 class="card-subtitle">Edit the details below to update the category</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Electronics"
                            :value="$category->name" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Mobile phones, laptops and accessories" :value="$category->description" />

                        <x-admin.input-select name="is_featured" :label="__('Featured')" :selected="old('is_featured', (string) (int) $category->is_featured)">
                            <option value="1" @selected(old('is_featured', (string) (int) $category->is_featured) === '1')>Yes</option>
                            <option value="0" @selected(old('is_featured', (string) (int) $category->is_featured) === '0')>No</option>
                        </x-admin.input-select>

                        <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', $category->status)">
                            <option value="published" @selected(old('status', $category->status) === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status', $category->status) === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Category')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection