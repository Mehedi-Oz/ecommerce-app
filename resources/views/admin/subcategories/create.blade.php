@extends('admin.layouts.master')

@section('title', 'Add Subcategory')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Subcategory</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new subcategory</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.subcategories.store') }}" method="POST">
                        @csrf

                        <x-admin.input-select name="category_id" :label="__('Category')">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}</option>
                            @endforeach
                        </x-admin.input-select>

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Mobile Phones" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Smartphones, tablets and accessories" />

                        <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', 'published')">
                            <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status') === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Create Subcategory')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
