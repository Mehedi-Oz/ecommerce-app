@extends('admin.layouts.master')

@section('title', 'Manage Banners')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">Manage Banners</h4>
                <h6 class="card-subtitle">List of all homepage banners</h6>
                <div class="table-responsive m-t-40">
                    <table class="table table-striped table-bordered admin-data-table">
                        <thead>
                            <tr>
                                <th class="text-nowrap">#</th>
                                <th class="text-nowrap">Image</th>
                                <th>Location</th>
                                <th>Title</th>
                                <th class="text-nowrap">Active</th>
                                <th class="text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($banners as $banner)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">
                                        @if ($banner->image)
                                            <x-admin.image-preview :src="$banner->image"
                                                style="width: 80px; height: 40px; object-fit: cover;" />
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info text-white">{{ str_replace('_', ' ', $banner->location) }}</span></td>
                                    <td>{{ $banner->title ?? '—' }}</td>
                                    <td class="text-nowrap">
                                        @if ($banner->is_active)
                                            <span class="badge bg-success text-white">Active</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <span class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('admin.banners.edit', $banner) }}" title="Edit"
                                            class="btn btn-sm btn-primary text-white me-1"
                                            style="width: 32px; height: 32px;"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.banners.status', $banner) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" title="Toggle active"
                                                class="btn btn-sm btn-warning text-white me-1"
                                                style="width: 32px; height: 32px;"><i class="fas fa-toggle-on"></i></button>
                                        </form>
                                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                class="btn btn-sm btn-danger text-white"
                                                style="width: 32px; height: 32px;"><i class="fas fa-trash"></i></button>
                                        </form>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No banners found</td>
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
