@extends('admin.layouts.master')

@section('title', 'Update Subcategory')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Subcategory</h4>
                    <h6 class="card-subtitle">Edit the details below to update the subcategory</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.subcategories.update', $subcategory) }}">
                        @csrf
                        @method('PUT')

                        <x-admin.input-select name="category_id" :label="__('Category')"
                            :selected="old('category_id', $subcategory->category_id)">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $subcategory->category_id) == $category->id)>
                                    {{ $category->name }}</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Mobile Phones"
                            :value="$subcategory->name" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Smartphones, tablets and accessories" :value="$subcategory->description" />

                        <x-admin.input-select name="status" :label="__('Status')"
                            :selected="old('status', $subcategory->status)">
                            <option value="published" @selected(old('status', $subcategory->status) === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status', $subcategory->status) === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Subcategory')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection