@extends('admin.layouts.master')

@section('title', 'Update Brand')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Brand</h4>
                    <h6 class="card-subtitle">Edit the details below to update the brand</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. Apple"
                            :value="$brand->name" required />

                        <x-admin.input-text-area name="description" :label="__('Description')"
                            placeholder="e.g. Premium consumer electronics and software" :value="$brand->description" />

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            @if ($brand->image)
                                <x-admin.image-preview :src="$brand->image" class="mb-2" />
                            @endif
                            <div class="@error('image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="image"
                                    data-default-file="{{ $brand->image ? asset($brand->image) : '' }}" />
                            </div>
                            <x-admin.input-error :for="'image'" />
                        </div>

                        <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', $brand->status)">
                            <option value="published" @selected(old('status', $brand->status) === 'published')>Published</option>
                            <option value="unpublished" @selected(old('status', $brand->status) === 'unpublished')>Unpublished</option>
                        </x-admin.input-select>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Brand')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection