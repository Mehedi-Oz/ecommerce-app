<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LukePOLO\LaraCart\Facades\LaraCart;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (LaraCart::count() === 0) {
            return redirect()->route('products');
        }

        $shipping = $this->shippingTotal();

        return view('frontend.checkout.index', [
            'items' => LaraCart::getItems(),
            'subTotal' => LaraCart::subTotal(false),
            'taxTotal' => LaraCart::taxTotal(false),
            'shipping' => $shipping,
            'total' => LaraCart::total(false),
        ]);
    }

    public function completed(): View
    {
        return view('frontend.checkout.completed');
    }

    public function storeCashOnDelivery(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'delivery_address' => ['required', 'string'],
            'terms' => ['accepted'],
        ]);

        if (LaraCart::count() === 0) {
            NotificationService::error(__('Your cart is empty.'));

            return redirect()->route('cart.index');
        }

        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['full_name'],
                'mobile' => $validated['phone'],
                'password' => Hash::make($validated['phone']),
                'address' => $validated['delivery_address'],
            ]
        );

        $totals = [
            'shipping' => $this->shippingTotal(),
            'total' => LaraCart::total(false),
            'tax' => LaraCart::taxTotal(false),
            'items' => LaraCart::getItems(),
        ];

        DB::transaction(function () use ($customer, $validated, $totals) {
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_total' => $totals['total'],
                'tax_total' => $totals['tax'],
                'shipping_total' => $totals['shipping'],
                'order_status' => 'pending',
                'delivery_address' => $validated['delivery_address'],
                'delivery_status' => 'pending',
                'payment_type' => 'cash_on_delivery',
                'payment_status' => 'pending',
                'currency' => 'BDT',
            ]);

            foreach ($totals['items'] as $item) {
                $order->details()->create([
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'product_price' => $item->price,
                    'product_quantity' => $item->qty,
                ]);
            }
        });

        LaraCart::emptyCart();

        NotificationService::created(__('Order placed successfully.'));

        return redirect()->route('checkout.completed');
    }

    private function shippingTotal(): float
    {
        LaraCart::addFee('shipping', 20);

        return LaraCart::getFee('shipping')?->getAmount(false) ?? 0;
    }
}
