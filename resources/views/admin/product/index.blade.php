@extends('admin.layouts.master')

@section('title', 'Manage Products')

@section('content')
    <div class="row">
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">Manage Products</h4>
                <h6 class="card-subtitle">List of all products</h6>
                <div class="table-responsive m-t-40">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($product->featured_image)
                                            <x-admin.image-preview :src="$product->featured_image"
                                                style="width: 50px; height: 50px; object-fit: cover;" />
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info text-white">{{ $product->code }}</span></td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category?->name ?? '—' }}</td>
                                    <td>{{ $product->brand?->name ?? '—' }}</td>
                                    <td>${{ number_format($product->selling_amount, 2) }}</td>
                                    <td>
                                        @if ($product->stock_amount > 0)
                                            <span class="badge bg-success text-white">{{ $product->stock_amount }}</span>
                                        @else
                                            <span class="badge bg-danger text-white">Out of stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.products.featured', $product) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if ($product->featured_status === 'featured')
                                                <button type="submit" title="Unfeature product"
                                                    class="btn btn-sm text-warning border-0 bg-transparent"><i
                                                        class="fas fa-star"></i></button>
                                            @else
                                                <button type="submit" title="Feature product"
                                                    class="btn btn-sm text-muted border-0 bg-transparent"><i
                                                        class="far fa-star"></i></button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        @if ($product->status === 'published')
                                            <span class="badge bg-success text-white">Published</span>
                                        @else
                                            <span class="badge bg-warning text-white">Unpublished</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $product) }}" title="View"
                                            class="btn btn-sm btn-info text-white me-1"
                                            style="width: 32px; height: 32px;"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.products.edit', $product) }}" title="Edit"
                                            class="btn btn-sm btn-primary text-white me-1"
                                            style="width: 32px; height: 32px;"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.products.status', $product) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if ($product->status === 'published')
                                                <button type="submit" title="Unpublish product"
                                                    class="btn btn-sm btn-warning text-white me-1"
                                                    style="width: 32px; height: 32px;"><i
                                                        class="fas fa-toggle-on"></i></button>
                                            @else
                                                <button type="submit" title="Publish product"
                                                    class="btn btn-sm btn-success text-white me-1"
                                                    style="width: 32px; height: 32px;"><i
                                                        class="fas fa-toggle-off"></i></button>
                                            @endif
                                        </form>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                class="btn btn-sm btn-danger text-white"
                                                style="width: 32px; height: 32px;"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No products found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
