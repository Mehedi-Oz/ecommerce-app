@extends('admin.layouts.master')

@section('title', 'Update Product')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Product</h4>
                    <h6 class="card-subtitle">Edit the details below to update the product</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-select name="category_id" :label="__('Category')"
                                    :selected="old('category_id', $product->category_id)">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id', $product->category_id) == $category->id)>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="sub_category_id" :label="__('Subcategory')"
                                    :selected="old('sub_category_id', $product->sub_category_id)">
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            data-category-id="{{ $subCategory->category_id }}"
                                            @selected(old('sub_category_id', $product->sub_category_id) == $subCategory->id)>
                                            {{ $subCategory->name }}</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-select name="brand_id" :label="__('Brand')"
                                    :selected="old('brand_id', $product->brand_id)">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="unit_id" :label="__('Unit')"
                                    :selected="old('unit_id', $product->unit_id)">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            @selected(old('unit_id', $product->unit_id) == $unit->id)>
                                            {{ $unit->name }} ({{ $unit->code }})</option>
                                    @endforeach
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="name" :label="__('Name')" placeholder="e.g. iPhone 15 Pro"
                                    :value="$product->name" required />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-text name="code" :label="__('Code')" placeholder="e.g. IP15P-128"
                                    :value="$product->code" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-admin.input-text name="model" :label="__('Model')" placeholder="e.g. A2848"
                                    :value="$product->model" />
                            </div>
                            <div class="col-md-4">
                                <x-admin.input-text name="stock_amount" type="number" :label="__('Stock Amount')"
                                    :value="$product->stock_amount" min="0" required />
                            </div>
                            <div class="col-md-4">
                                <x-admin.input-text name="regular_amount" type="number" step="0.01"
                                    :label="__('Regular Amount')" :value="$product->regular_amount" min="0" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-text name="selling_amount" type="number" step="0.01"
                                    :label="__('Selling Amount')" :value="$product->selling_amount" min="0"
                                    hint="Must be less than the regular amount." required />
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-text name="hit_count" type="number" :label="__('Hit Count')"
                                    :value="$product->hit_count" hint="View count - managed by the system."
                                    disabled />
                            </div>
                        </div>

                        <x-admin.input-text-area name="short_description" :label="__('Short Description')"
                            placeholder="e.g. A brief summary of the product" rows="3"
                            :value="$product->short_description" />

                        <x-admin.input-text-area name="long_description" :label="__('Long Description')"
                            placeholder="e.g. Full details, features and specifications" rows="6"
                            :value="$product->long_description" />

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            <div class="@error('featured_image') is-dropify-invalid @enderror">
                                <input type="file" class="dropify" name="featured_image"
                                    data-default-file="{{ $product->featured_image ? asset($product->featured_image) : '' }}" />
                            </div>
                            <x-admin.input-error :for="'featured_image'" />
                        </div>

                        @if ($product->images->isNotEmpty())
                            <div class="mb-3">
                                <label class="form-label">Gallery Images</label>
                                <div class="row">
                                    @foreach ($product->images->sortBy('sort_order') as $image)
                                        <div class="col-md-3 mb-3">
                                            <div class="position-relative">
                                                <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}"
                                                    class="img-fluid rounded"
                                                    style="width: 100%; height: 150px; object-fit: cover;" />
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="remove_gallery_images[]" value="{{ $image->id }}"
                                                        id="remove_image_{{ $image->id }}">
                                                    <label class="form-check-label text-danger"
                                                        for="remove_image_{{ $image->id }}">Remove</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Add Gallery Images</label>
                            <input type="file" class="form-control" name="gallery_images[]" multiple accept="image/*" />
                            <small class="form-text text-muted">You can add up to 5 gallery images in total (existing + new).</small>
                            <x-admin.input-error :for="'gallery_images'" />
                            @error('gallery_images.*')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                            <x-admin.input-error :for="'remove_gallery_images'" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Homepage Tags</label>
                            @php($selectedTags = old('tags', $product->tags->pluck('slug')->all()))
                            <div class="d-flex gap-3">
                                @foreach ($tags as $tag)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="tags[]"
                                            value="{{ $tag->slug }}" id="tag_{{ $tag->slug }}"
                                            @checked(in_array($tag->slug, $selectedTags))>
                                        <label class="form-check-label" for="tag_{{ $tag->slug }}">{{ $tag->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="form-text text-muted">Special Offer and Top Rated sections use these tags.</small>
                            <x-admin.input-error :for="'tags'" />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-admin.input-select name="featured_status" :label="__('Featured Status')"
                                    :selected="old('featured_status', $product->featured_status)">
                                    <option value="featured" @selected(old('featured_status', $product->featured_status) === 'featured')>Featured</option>
                                    <option value="not_featured" @selected(old('featured_status', $product->featured_status) === 'not_featured')>Not Featured</option>
                                </x-admin.input-select>
                            </div>
                            <div class="col-md-6">
                                <x-admin.input-select name="status" :label="__('Status')"
                                    :selected="old('status', $product->status)">
                                    <option value="published" @selected(old('status', $product->status) === 'published')>Published</option>
                                    <option value="unpublished" @selected(old('status', $product->status) === 'unpublished')>Unpublished</option>
                                </x-admin.input-select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-admin.submit-button :label="__('Update Product')" />
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
                var currentValue = String($subCategorySelect.val() || '');
                var isCurrentValid = false;

                $subCategorySelect.find('option').each(function() {
                    var option = $(this);
                    var optionCategoryId = option.data('category-id');

                    if (optionCategoryId === undefined) {
                        option.prop('hidden', false);
                        option.prop('disabled', true);

                        return;
                    }

                    var matches = String(optionCategoryId) === categoryId;

                    option.prop('hidden', !matches);
                    option.prop('disabled', !matches);

                    if (matches && option.val() === currentValue) {
                        isCurrentValid = true;
                    }
                });

                $subCategorySelect.val(isCurrentValid ? currentValue : '');
            }

            $categorySelect.on('change', function() {
                $subCategorySelect.val('');
                filterSubCategories();
            });

            filterSubCategories();
        });
    </script>
@endpush
