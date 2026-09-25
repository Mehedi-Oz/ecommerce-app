@extends('admin.layouts.master')

@section('title', 'Add Product')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add a New Product</h4>
                    <h6 class="card-subtitle">Fill in the details below to create a new product</h6>
                    <form class="form-horizontal p-t-20" action="{{ route('admin.products.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-select name="category_id" :label="__('Category')">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="sub_category_id" :label="__('Subcategory')">
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            data-category-id="{{ $subCategory->category_id }}"
                                            @selected(old('sub_category_id') == $subCategory->id)>
                                            {{ $subCategory->name }}</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-select name="brand_id" :label="__('Brand')">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="unit_id" :label="__('Unit')">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                                            {{ $unit->name }} ({{ $unit->code }})</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. iPhone 15 Pro"
                                    required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="code" :label="__('Code')" placeholder="e.g. IP15P-128"
                                    required />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-text name="model" :label="__('Model')" placeholder="e.g. A2848" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-admin.input-text name="stock_amount" type="number" :label="__('Stock Amount')"
                                    placeholder="e.g. 100" value="0" required />
                            </div>
                            <div class="col-md-4">
                                <x-admin.input-text name="regular_amount" type="number" step="0.01"
                                    :label="__('Regular Amount')" placeholder="e.g. 1299.00" required />
                            </div>
                            <div class="col-md-4">
                                <x-admin.input-text name="selling_amount" type="number" step="0.01"
                                    :label="__('Selling Amount')" placeholder="e.g. 1199.00" required />
                            </div>
                        </div>

                        <x-admin.input-text-area name="short_description" :label="__('Short Description')"
                            placeholder="e.g. A brief summary of the product" rows="3" />

                        <x-admin.input-text-area name="long_description" :label="__('Long Description')"
                            placeholder="e.g. Full details, features and specifications" rows="6" />

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            <div class="@error('featured_image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="featured_image" />
                            </div>
                            <x-admin.input-error :for="'featured_image'" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gallery Images</label>
                            <div class="@error('gallery_images') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="gallery_images[]" multiple
                                    data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png webp gif" />
                            </div>
                            <small class="form-text text-muted">You can select up to 5 additional product images.</small>
                            <x-admin.input-error :for="'gallery_images'" />
                            @error('gallery_images.*')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Homepage Tags</label>
                            <div class="d-flex gap-3">
                                @foreach ($tags as $tag)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="tags[]"
                                            value="{{ $tag->slug }}" id="tag_{{ $tag->slug }}"
                                            @checked(in_array($tag->slug, old('tags', [])))>
                                        <label class="form-check-label" for="tag_{{ $tag->slug }}">{{ $tag->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="form-text text-muted">Special Offer section uses these tags.</small>
                            <x-admin.input-error :for="'tags'" />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-select name="featured_status" :label="__('Featured Status')"
                                    :selected="old('featured_status', 'not_featured')">
                                    <option value="featured" @selected(old('featured_status', 'not_featured') === 'featured')>Featured</option>
                                    <option value="not_featured" @selected(old('featured_status', 'not_featured') === 'not_featured')>Not Featured</option>
                                </x-admin.input-select>
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="status" :label="__('Status')" :selected="old('status', 'published')">
                                    <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                                    <option value="unpublished" @selected(old('status', 'published') === 'unpublished')>Unpublished</option>
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Create Product')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            var $categorySelect = $('#category_id');
            var $subCategorySelect = $('#sub_category_id');

            function filterSubCategories() {
                var categoryId = String($categorySelect.val());

                $subCategorySelect.find('option').each(function() {
                    var option = $(this);
                    var matches = option.data('category-id') !== undefined &&
                        String(option.data('category-id')) === categoryId;

                    option.prop('hidden', !matches);
                    option.prop('disabled', !matches);
                });
            }

            $categorySelect.on('change', function() {
                $subCategorySelect.val('');
                filterSubCategories();
            });

            filterSubCategories();
        });
    </script>
@endpush
