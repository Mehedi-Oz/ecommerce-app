@extends('admin.layouts.master')

@section('title', 'View Order')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order #{{ $order->id }}</h4>
                    <h6 class="card-subtitle">Order details</h6>

                    <div class="mb-4">
                        @if ($order->order_status === 'completed')
                            <span class="badge bg-success text-white me-2 mb-1">Completed</span>
                        @elseif ($order->order_status === 'processing')
                            <span class="badge bg-info text-white me-2 mb-1">Processing</span>
                        @elseif ($order->order_status === 'cancelled')
                            <span class="badge bg-danger text-white me-2 mb-1">Cancelled</span>
                        @else
                            <span class="badge bg-warning text-white me-2 mb-1">Pending</span>
                        @endif
                        @if ($order->payment_status === 'paid')
                            <span class="badge bg-success text-white me-2 mb-1">Paid</span>
                        @elseif ($order->payment_status === 'failed')
                            <span class="badge bg-danger text-white me-2 mb-1">Failed</span>
                        @elseif ($order->payment_status === 'refunded')
                            <span class="badge bg-secondary text-white me-2 mb-1">Refunded</span>
                        @else
                            <span class="badge bg-warning text-white me-2 mb-1">Payment Pending</span>
                        @endif
                    </div>

                    <h5 class="mb-3">Order Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Order Number</th>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tax Total</th>
                                    <td>৳ {{ number_format($order->tax_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping Total</th>
                                    <td>৳ {{ number_format($order->shipping_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Order Total</th>
                                    <td>৳ {{ number_format($order->order_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td>{{ ucfirst($order->order_status) }}</td>
                                </tr>
                                <tr>
                                    <th>Delivery Address</th>
                                    <td>{{ $order->delivery_address }}</td>
                                </tr>
                                <tr>
                                    <th>Delivery Status</th>
                                    <td>{{ ucfirst($order->delivery_status) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                </tr>
                                <tr>
                                    <th>Currency</th>
                                    <td>{{ $order->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>{{ $order->transaction_id ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-4 mb-3">Customer Info</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Name</th>
                                    <td>{{ $order->user?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $order->user?->email ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>{{ $order->user?->phone ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $order->user?->address ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-4 mb-3">Products Details</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Serial</th>
                                    <th>Product Name</th>
                                    <th class="text-nowrap">Price</th>
                                    <th class="text-nowrap">Quantity</th>
                                    <th class="text-nowrap">Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->details as $detail)
                                    <tr>
                                        <td class="text-nowrap">{{ $loop->iteration }}</td>
                                        <td>{{ $detail->product_name }}</td>
                                        <td class="text-nowrap">৳ {{ number_format($detail->product_price, 2) }}</td>
                                        <td class="text-nowrap">{{ $detail->product_quantity }}</td>
                                        <td class="text-nowrap">৳ {{ number_format($detail->product_price * $detail->product_quantity, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No items found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.orders.edit', $order) }}"
                            class="btn btn-primary text-white me-2"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i
                                class="fas fa-arrow-left"></i> Back</a>
                    </div>

                    <h5 class="mt-4 mb-3">Status History</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">Field</th>
                                    <th class="text-nowrap">Changed</th>
                                    <th>By</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->histories as $history)
                                    <tr>
                                        <td class="text-nowrap">{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-nowrap">{{ ucfirst(str_replace('_', ' ', $history->field)) }}</td>
                                        <td class="text-nowrap">{{ $history->old_value ?? '—' }} &rarr; {{ $history->new_value ?? '—' }}</td>
                                        <td>{{ $history->admin?->name ?? '—' }}</td>
                                        <td>{{ $history->note ?: '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No changes recorded yet</td>
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
