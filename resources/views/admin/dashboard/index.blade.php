@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Dashboard</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- KPI cards -->
    <!-- ============================================================== -->
    <div class="row g-3">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-primary text-white"><i class="ti-money"></i></div>
                        <p class="stat-label ms-3">TOTAL REVENUE</p>
                    </div>
                    <div class="stat-value text-primary">৳ {{ number_format($revenue, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-cyan text-white"><i class="ti-shopping-cart"></i></div>
                        <p class="stat-label ms-3">TOTAL ORDERS</p>
                    </div>
                    <div class="stat-value text-cyan">{{ number_format($ordersCount) }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-purple text-white"><i class="ti-package"></i></div>
                        <p class="stat-label ms-3">TOTAL PRODUCTS</p>
                    </div>
                    <div class="stat-value text-purple">{{ number_format($productsCount) }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-success text-white"><i class="ti-user"></i></div>
                        <p class="stat-label ms-3">TOTAL CUSTOMERS</p>
                    </div>
                    <div class="stat-value text-success">{{ number_format($customersCount) }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End KPI cards -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Action alerts -->
    <!-- ============================================================== -->
    <div class="row g-3 mt-0">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-warning text-white me-3"><i class="ti-alarm-clock"></i></div>
                    <div class="me-auto">
                        <h5 class="card-title mb-1">Pending Orders</h5>
                        <h6 class="card-subtitle mb-0">{{ $pendingOrdersCount }} {{ Str::plural('order', $pendingOrdersCount) }} waiting for confirmation</h6>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-info text-white">Review</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-danger text-white me-3"><i class="ti-package"></i></div>
                    <div class="me-auto">
                        <h5 class="card-title mb-1">Low Stock</h5>
                        <h6 class="card-subtitle mb-0">{{ $lowStockCount }} {{ Str::plural('product', $lowStockCount) }} at 5 units or fewer</h6>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-warning text-white">Restock</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Action alerts -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Sales chart + orders by status -->
    <!-- ============================================================== -->
    <div class="row g-3 mt-0">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Revenue — Last 14 Days</h4>
                            <h6 class="card-subtitle mb-0">Non-cancelled orders only</h6>
                        </div>
                        <span class="badge bg-cyan text-white ms-auto">৳ {{ number_format($revenue, 2) }}</span>
                    </div>
                    <div id="morris-area-chart" class="chart-area mt-3"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title mb-1">Orders by Status</h4>
                    <h6 class="card-subtitle mb-0">All time</h6>
                    @if ($ordersCount > 0)
                        <div id="morris-donut-chart" class="chart-donut mt-3"></div>
                    @else
                        <p class="text-muted text-center my-auto">No orders yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Sales chart + orders by status -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Recent orders + inventory -->
    <!-- ============================================================== -->
    <div class="row g-3 mt-0">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Recent Orders</h4>
                            <h6 class="card-subtitle mb-0">Latest customer orders</h6>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="ms-auto">View all</a>
                    </div>
                    <div class="table-responsive m-t-20">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">#</th>
                                    <th>Customer</th>
                                    <th class="text-nowrap">Total</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Payment</th>
                                    <th class="text-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $order)
                                    <tr>
                                        <td class="text-nowrap"><span class="badge bg-info text-white">#{{ $order->id }}</span></td>
                                        <td>{{ $order->user?->name ?? '—' }}</td>
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
                                        <td class="text-nowrap text-center">
                                            <a href="{{ route('admin.orders.show', $order) }}" title="View"
                                                class="btn btn-icon btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No orders yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Low Stock</h4>
                            <h6 class="card-subtitle mb-0">5 units or fewer</h6>
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="ms-auto">View all</a>
                    </div>
                    <ul class="list-group list-group-flush mt-2">
                        @forelse ($lowStockProducts as $product)
                            <li class="list-group-item d-flex align-items-center px-0">
                                <div class="dash-item-main me-auto">
                                    <div class="fw-semibold text-truncate">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->category?->name ?? '—' }}</small>
                                </div>
                                <span
                                    class="badge {{ $product->stock_amount === 0 ? 'bg-danger' : 'bg-warning' }} text-white ms-2">{{ $product->stock_amount }} left</span>
                                <a href="{{ route('admin.products.edit', $product) }}" title="Restock"
                                    class="btn btn-icon btn-sm btn-primary text-white ms-2"><i
                                        class="fas fa-pencil-alt"></i></a>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">All products are stocked</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Top Products</h4>
                            <h6 class="card-subtitle mb-0">By units sold</h6>
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="ms-auto">View all</a>
                    </div>
                    <ul class="list-group list-group-flush mt-2">
                        @forelse ($topProducts as $product)
                            <li class="list-group-item d-flex align-items-center px-0">
                                <div class="dash-item-main me-auto">
                                    <div class="fw-semibold text-truncate">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->category?->name ?? '—' }}</small>
                                </div>
                                <span class="badge bg-success text-white ms-2">{{ $product->sales_count }} sold</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">No sales yet</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Recent orders + inventory -->
    <!-- ============================================================== -->
@endsection

@push('scripts')
    <!--morris JavaScript -->
    <script src="{{ asset('assets/admin/node_modules/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/admin/node_modules/morrisjs/morris.min.js') }}"></script>
    <script>
        $(function () {
            "use strict";
            Morris.Area({
                element: 'morris-area-chart',
                data: @json($salesSeries),
                xkey: 'period',
                ykeys: ['revenue'],
                labels: ['Revenue (৳)'],
                pointSize: 3,
                fillOpacity: 0.2,
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                lineWidth: 3,
                hideHover: 'auto',
                lineColors: ['#01c0c8'],
                pointStrokeColors: ['#01c0c8'],
                resize: true
            });
            @if ($ordersCount > 0)
                Morris.Donut({
                    element: 'morris-donut-chart',
                    data: @json(collect($ordersByStatus)->map(fn ($total, $status) => ['label' => ucfirst($status), 'value' => $total])->values()),
                    colors: ['#fb9678', '#01c0c8', '#38d39f', '#e46a76'],
                    resize: true
                });
            @endif
        });
    </script>
@endpush