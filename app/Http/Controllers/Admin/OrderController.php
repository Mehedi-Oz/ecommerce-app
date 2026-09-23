<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['user', 'details'])->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'details', 'histories.admin']);

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        return view('admin.orders.edit', [
            'order' => $order,
            'allowed' => [
                'order_status' => OrderUpdateRequest::allowedValues('order_status', $order->order_status),
                'delivery_status' => OrderUpdateRequest::allowedValues('delivery_status', $order->delivery_status),
                'payment_status' => OrderUpdateRequest::allowedValues('payment_status', $order->payment_status),
            ],
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $order): void {
            $original = $order->getOriginal();

            $changes = [];

            foreach (['order_status', 'delivery_status', 'payment_status', 'delivery_address'] as $field) {
                if (($data[$field] ?? null) !== ($original[$field] ?? null)) {
                    $changes[$field] = [$original[$field] ?? null, $data[$field]];
                }
            }

            $cancelling = ($data['order_status'] ?? null) === 'cancelled' && ($original['order_status'] ?? null) !== 'cancelled';
            $returning = ($data['delivery_status'] ?? null) === 'returned' && ($original['delivery_status'] ?? null) !== 'returned';
            $reserved = in_array($original['payment_status'] ?? null, ['pending', 'paid'], true);
            $firstTerminal = ($original['order_status'] ?? null) !== 'cancelled' && ($original['delivery_status'] ?? null) !== 'returned';

            if (($cancelling || $returning) && $reserved && $firstTerminal) {
                foreach ($order->details as $detail) {
                    Product::query()->whereKey($detail->product_id)->increment('stock_amount', $detail->product_quantity);
                }
            }

            $delivering = ($data['delivery_status'] ?? null) === 'delivered'
                && ($original['delivery_status'] ?? null) !== 'delivered'
                && ($original['order_status'] ?? null) !== 'cancelled';
            $returningDelivered = ($data['delivery_status'] ?? null) === 'returned'
                && ($original['delivery_status'] ?? null) === 'delivered';

            if ($delivering) {
                foreach ($order->details as $detail) {
                    Product::query()->whereKey($detail->product_id)->increment('sales_count', $detail->product_quantity);
                }
            }

            if ($returningDelivered) {
                foreach ($order->details as $detail) {
                    $product = Product::query()->whereKey($detail->product_id)->first();

                    if ($product !== null) {
                        $product->decrement('sales_count', min($detail->product_quantity, $product->sales_count));
                    }
                }
            }

            $order->fill([
                'order_status' => $data['order_status'],
                'delivery_status' => $data['delivery_status'],
                'payment_status' => $data['payment_status'],
                'delivery_address' => $data['delivery_address'],
            ]);

            if ($order->isDirty()) {
                $order->save();
            }

            foreach ($changes as $field => [$oldValue, $newValue]) {
                $order->histories()->create([
                    'admin_id' => auth('admin')->id(),
                    'field' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'note' => $data['note'] ?? null,
                ]);
            }
        });

        NotificationService::updated();

        return redirect()->route('admin.orders.show', $order);
    }

    public function destroy(Order $order): RedirectResponse
    {
        DB::transaction(function () use ($order) {
            if (in_array($order->payment_status, ['pending', 'paid'], true)) {
                foreach ($order->details as $detail) {
                    Product::query()->whereKey($detail->product_id)->increment('stock_amount', $detail->product_quantity);
                }
            }

            $order->details()->delete();
            $order->delete();
        });

        NotificationService::deleted();

        return redirect()->route('admin.orders.index');
    }
}
