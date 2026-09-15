@extends('admin.layouts.master')

@section('title', 'Manage Subcategories')

@section('content')
    <div class="row">
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">Manage Subcategories</h4>
                <h6 class="card-subtitle">List of all subcategories</h6>
                <div class="table-responsive m-t-40">
                    <table class="table table-striped table-bordered admin-data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subCategories as $subcategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($subcategory->image)
                                            <x-admin.image-preview :src="$subcategory->image"
                                                style="width: 50px; height: 50px; object-fit: cover;" />
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>
                                    <td>{{ $subcategory->category?->name ?? '—' }}</td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>
                                        @if ($subcategory->description)
                                            <span class="description-clamp" title="Click to expand">{{ $subcategory->description }}</span>
                                            <a href="javascript:void(0)" class="description-toggle" title="Toggle full description">Show more</a>
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subcategory->status === 'published')
                                            <span class="badge bg-success text-white">Published</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Unpublished</span>
                                        @endif
                                    </td>
                                    <td>{{ $subcategory->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.subcategories.edit', $subcategory) }}" title="Edit"
                                            class="btn btn-sm btn-primary text-white me-1"
                                            style="width: 32px; height: 32px;"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.subcategories.status', $subcategory) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if ($subcategory->status === 'published')
                                                <button type="submit" title="Unpublish subcategory"
                                                    class="btn btn-sm btn-warning text-white me-1"
                                                    style="width: 32px; height: 32px;"><i
                                                        class="fas fa-toggle-on"></i></button>
                                            @else
                                                <button type="submit" title="Publish subcategory"
                                                    class="btn btn-sm btn-success text-white me-1"
                                                    style="width: 32px; height: 32px;"><i
                                                        class="fas fa-toggle-off"></i></button>
                                            @endif
                                        </form>
                                        <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
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
                                    <td colspan="8" class="text-center">No subcategories found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection