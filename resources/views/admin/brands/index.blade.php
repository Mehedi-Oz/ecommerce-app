@extends('admin.layouts.master')

@section('title', 'Manage Brands')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">Manage Brands</h4>
                <h6 class="card-subtitle">List of all brands</h6>
                <div class="table-responsive m-t-40">
                    <table class="table table-striped table-bordered admin-data-table">
                        <thead>
                            <tr>
                                <th class="text-nowrap">#</th>
                                <th class="text-nowrap">Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Created At</th>
                                <th class="text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $brand)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">
                                        @if ($brand->image)
                                            <x-admin.image-preview :src="$brand->image"
                                                style="width: 50px; height: 50px; object-fit: cover;" />
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        @if ($brand->description)
                                            <span class="description-clamp" title="Click to expand">{{ $brand->description }}</span>
                                            <a href="javascript:void(0)" class="description-toggle" title="Toggle full description">Show more</a>
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($brand->status === 'published')
                                            <span class="badge bg-success text-white">Published</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Unpublished</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ $brand->created_at->format('d/m/Y') }}</td>
                                    <td class="text-nowrap">
                                        <span class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('admin.brands.edit', $brand) }}" title="Edit"
                                            class="btn btn-sm btn-primary text-white me-1"
                                            style="width: 32px; height: 32px;"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.brands.status', $brand) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if ($brand->status === 'published')
                                                <button type="submit" title="Unpublish brand"
                                                    class="btn btn-sm btn-warning text-white me-1"
                                                    style="width: 32px; height: 32px;"><i
                                                        class="fas fa-toggle-on"></i></button>
                                            @else
                                                <button type="submit" title="Publish brand"
                                                    class="btn btn-sm btn-success text-white me-1"
                                                    style="width: 32px; height: 32px;"><i
                                                        class="fas fa-toggle-off"></i></button>
                                            @endif
                                        </form>
                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure you want to delete this brand?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                class="btn btn-sm btn-danger text-white"
                                                style="width: 32px; height: 32px;"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No brands found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection