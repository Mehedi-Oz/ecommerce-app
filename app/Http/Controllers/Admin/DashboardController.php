<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $revenue = (float) Order::query()
            ->where('order_status', '!=', 'cancelled')
            ->sum('order_total');

        $salesSeries = $this->salesSeries();

        return view('admin.dashboard.index', [
            'revenue' => $revenue,
            'ordersCount' => Order::query()->count(),
            'productsCount' => Product::query()->where('status', 'published')->count(),
            'customersCount' => User::query()->count(),
            'pendingOrdersCount' => Order::query()->where('order_status', 'pending')->count(),
            'lowStockCount' => Product::query()->where('stock_amount', '<=', 5)->count(),
            'lowStockProducts' => Product::query()
                ->where('stock_amount', '<=', 5)
                ->orderBy('stock_amount')
                ->with('category')
                ->take(8)
                ->get(),
            'recentOrders' => Order::query()
                ->with('user')
                ->latest()
                ->take(8)
                ->get(),
            'topProducts' => Product::query()
                ->where('status', 'published')
                ->orderByDesc('sales_count')
                ->with('category')
                ->take(5)
                ->get(),
            'ordersByStatus' => Order::query()
                ->selectRaw('order_status, count(*) as total')
                ->groupBy('order_status')
                ->pluck('total', 'order_status')
                ->all(),
            'salesSeries' => $salesSeries,
        ]);
    }

    /**
     * Revenue per day for the last 14 days (zero-filled), excluding cancelled orders.
     *
     * @return array<int, array{period: string, revenue: float}>
     */
    private function salesSeries(): array
    {
        $start = Carbon::today()->subDays(13);

        $totals = Order::query()
            ->where('order_status', '!=', 'cancelled')
            ->where('created_at', '>=', $start)
            ->selectRaw('date(created_at) as day, sum(order_total) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $series = [];

        for ($i = 0; $i < 14; $i++) {
            $day = $start->copy()->addDays($i)->toDateString();

            $series[] = [
                'period' => $day,
                'revenue' => (float) ($totals[$day] ?? 0),
            ];
        }

        return $series;
    }
}
