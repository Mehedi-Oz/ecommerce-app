@extends('admin.layouts.master')

@section('title', 'Manage Flash Deals')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">Manage Flash Deals</h4>
                <h6 class="card-subtitle">Only one active deal shows on the homepage</h6>
                <div class="table-responsive m-t-40">
                    <table class="table table-striped table-bordered admin-data-table">
                        <thead>
                            <tr>
                                <th class="text-nowrap">#</th>
                                <th>Product</th>
                                <th class="text-nowrap">Sale Price</th>
                                <th class="text-nowrap">Ends At</th>
                                <th class="text-nowrap">Active</th>
                                <th class="text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deals as $deal)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}</td>
                                    <td>{{ $deal->product?->name ?? '—' }}</td>
                                    <td class="text-nowrap">৳ {{ number_format($deal->sale_price, 2) }}</td>
                                    <td class="text-nowrap">{{ $deal->ends_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-nowrap">
                                        @if ($deal->is_active)
                                            <span class="badge bg-success text-white">Active</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <span class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('admin.flash-deals.edit', $deal) }}" title="Edit"
                                            class="btn btn-sm btn-primary text-white me-1"
                                            style="width: 32px; height: 32px;"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.flash-deals.status', $deal) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" title="Toggle active"
                                                class="btn btn-sm btn-warning text-white me-1"
                                                style="width: 32px; height: 32px;"><i class="fas fa-toggle-on"></i></button>
                                        </form>
                                        <form action="{{ route('admin.flash-deals.destroy', $deal) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure you want to delete this deal?')">
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
                                    <td colspan="6" class="text-center">No flash deals found</td>
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
