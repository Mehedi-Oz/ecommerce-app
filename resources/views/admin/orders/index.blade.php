@extends('admin.layouts.master')

@section('title', 'Manage Orders')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">Manage Orders</h4>
                <h6 class="card-subtitle">List of all customer orders</h6>
                <div class="table-responsive m-t-40">
                    <table class="table table-striped table-bordered admin-table-wide">
                        <thead>
                            <tr>
                                <th class="text-nowrap">#</th>
                                <th class="text-nowrap">Order Number</th>
                                <th class="text-nowrap">Order Date</th>
                                <th>Customer Info</th>
                                <th class="text-nowrap">Order Total</th>
                                <th class="text-nowrap">Order Status</th>
                                <th class="text-nowrap">Payment Status</th>
                                <th class="text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}</td>
                                    <td class="text-nowrap"><span class="badge bg-info text-white">#{{ $order->id }}</span></td>
                                    <td class="text-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $order->user?->name ?? '—' }}</div>
                                        <small class="text-muted d-block">{{ $order->user?->email ?? '—' }}</small>
                                        <small class="text-muted d-block">{{ $order->user?->phone ?? '—' }}</small>
                                    </td>
                                    <td class="text-nowrap">৳ {{ number_format($order->order_total, 2) }}</td>
                                    <td class="text-nowrap">
                                        @if ($order->order_status === 'completed')
                                            <span class="badge bg-success text-white">Completed</span>
                                        @elseif ($order->order_status === 'processing')
                                            <span class="badge bg-info text-white">Processing</span>
                                        @elseif ($order->order_status === 'cancelled')
                                            <span class="badge bg-danger text-white">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning text-white">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($order->payment_status === 'paid')
                                            <span class="badge bg-success text-white">Paid</span>
                                        @elseif ($order->payment_status === 'failed')
                                            <span class="badge bg-danger text-white">Failed</span>
                                        @elseif ($order->payment_status === 'refunded')
                                            <span class="badge bg-secondary text-white">Refunded</span>
                                        @else
                                            <span class="badge bg-warning text-white">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <span class="d-inline-flex align-items-center gap-1">
                                        <a href="{{ route('admin.orders.show', $order) }}" title="View"
                                            class="btn btn-sm btn-info text-white me-1"
                                            style="width: 32px; height: 32px;"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.orders.edit', $order) }}" title="Edit"
                                            class="btn btn-sm btn-primary text-white me-1"
                                            style="width: 32px; height: 32px;"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this order?')">
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
                                    <td colspan="8" class="text-center">No orders found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
