@extends('admin.layouts.master')

@section('title', 'View Product')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $product->name }}</h4>
                    <h6 class="card-subtitle">Product details</h6>

                    <div class="d-flex align-items-center mb-4">
                        @if ($product->featured_image)
                            <x-admin.image-preview :src="$product->featured_image"
                                style="width: 120px; height: 120px; object-fit: cover;" class="me-4" />
                        @endif
                        <div>
                            <span
                                class="badge bg-{{ $product->status === 'published' ? 'success' : 'warning' }} text-white me-2 mb-1">{{ ucfirst($product->status) }}</span>
                            <span
                                class="badge bg-{{ $product->featured_status === 'featured' ? 'warning' : 'secondary' }} text-white me-2 mb-1">{{ ucfirst(str_replace('_', ' ', $product->featured_status)) }}</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Code</th>
                                    <td>{{ $product->code }}</td>
                                </tr>
                                <tr>
                                    <th>Model</th>
                                    <td>{{ $product->model ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $product->category?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Subcategory</th>
                                    <td>{{ $product->subCategory?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Brand</th>
                                    <td>{{ $product->brand?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <td>{{ $product->unit ? $product->unit->name.' ('.$product->unit->code.')' : '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Stock Amount</th>
                                    <td>{{ $product->stock_amount }}</td>
                                </tr>
                                <tr>
                                    <th>Regular Amount</th>
                                    <td>৳ {{ number_format($product->regular_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Selling Amount</th>
                                    <td>৳ {{ number_format($product->selling_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Short Description</th>
                                    <td>{{ $product->short_description ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Long Description</th>
                                    <td>{!! $product->long_description ? nl2br(e($product->long_description)) : '—' !!}</td>
                                </tr>
                                <tr>
                                    <th>Hit Count</th>
                                    <td>{{ $product->hit_count }}</td>
                                </tr>
                                <tr>
                                    <th>Sales Count</th>
                                    <td>{{ $product->sales_count }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if ($product->images->isNotEmpty())
                        <h5 class="mt-4 mb-3">Gallery</h5>
                        <div class="row">
                            @foreach ($product->images->sortBy('sort_order') as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset($image->image_path) }}" class="img-fluid rounded"
                                        style="width: 100%; height: 150px; object-fit: cover;" />
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="btn btn-primary text-white me-2"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"><i
                                class="fas fa-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection