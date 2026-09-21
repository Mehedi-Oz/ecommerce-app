<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Rules\BangladeshiPhoneNumber;
use App\Services\NotificationService;
use App\Services\SslCommerzService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
        $orderId = session('last_order_id');
        $order = $orderId !== null ? Order::query()->whereKey($orderId)->first() : null;

        return view('frontend.checkout.completed', [
            'order' => $order,
        ]);
    }

    public function storeCashOnDelivery(Request $request): RedirectResponse
    {
        $validated = $this->validatedCheckoutData($request);

        if (LaraCart::count() === 0) {
            NotificationService::error(__('Your cart is empty.'));

            return redirect()->route('cart.index');
        }

        $user = $this->resolveUser($validated);

        $order = $this->createOrder($user, $validated, $this->totals(), 'cash_on_delivery');

        $accountCreated = $this->loginOrCreateUser($user);

        LaraCart::emptyCart();

        session(['last_order_id' => $order->id]);

        if ($accountCreated) {
            NotificationService::created(__('Order placed successfully. We have created an account for you and logged you in.'));
        } else {
            NotificationService::created(__('Order placed successfully.'));
        }

        return redirect()->route('checkout.completed');
    }

    public function storeOnlinePayment(Request $request): RedirectResponse
    {
        $validated = $this->validatedCheckoutData($request);

        if (LaraCart::count() === 0) {
            NotificationService::error(__('Your cart is empty.'));

            return redirect()->route('cart.index');
        }

        $user = $this->resolveUser($validated);

        $order = $this->createOrder($user, $validated, $this->totals(), 'online', $this->newTransactionId());

        $this->loginOrCreateUser($user);

        $gatewayUrl = app(SslCommerzService::class)->initiate($order, [
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['delivery_address'],
        ]);

        if ($gatewayUrl === null) {
            $this->markOrderUnpaid($order, 'cancelled', 'failed');

            NotificationService::error(__('We could not reach the payment gateway. Please try again.'));

            return redirect()->route('checkout')->withInput();
        }

        session(['sslcommerz_order_id' => $order->id]);

        LaraCart::emptyCart();

        return redirect()->away($gatewayUrl);
    }

    public function paymentSuccess(Request $request): RedirectResponse
    {
        if (! $this->verifySignature($request)) {
            abort(403);
        }

        $order = $this->orderByTransactionId($request->string('tran_id')->toString());

        $this->markOrderPaid($request->string('tran_id')->toString(), $request->string('val_id')->toString(), (float) $request->input('amount'));

        if ($order !== null) {
            session(['last_order_id' => $order->id]);
            $this->loginCheckoutUser($order);
            LaraCart::emptyCart();
        }

        return redirect()->route('checkout.completed');
    }

    public function paymentFail(Request $request): RedirectResponse
    {
        $order = $this->orderByTransactionId($request->string('tran_id')->toString());

        if ($order !== null) {
            $this->markOrderUnpaid($order, 'cancelled', 'failed');
        }

        NotificationService::error(__('Payment failed. Please try again.'));

        return redirect()->route('checkout');
    }

    public function paymentCancel(Request $request): RedirectResponse
    {
        $order = $this->orderByTransactionId($request->string('tran_id')->toString());

        if ($order !== null) {
            $this->markOrderUnpaid($order, 'cancelled', 'failed');
        }

        NotificationService::error(__('You cancelled the payment. Please try again.'));

        return redirect()->route('checkout');
    }

    public function paymentIpn(Request $request): Response
    {
        if (! $this->verifySignature($request)) {
            abort(403);
        }

        $order = $this->orderByTransactionId($request->string('tran_id')->toString());

        if ($order === null) {
            return response('OK');
        }

        match ($request->string('status')->toString()) {
            'VALID', 'VALIDATED' => $this->markOrderPaid($order->transaction_id, $request->string('val_id')->toString(), (float) $request->input('amount')),
            'FAILED' => $this->markOrderUnpaid($order, 'cancelled', 'failed'),
            'CANCELLED', 'EXPIRED' => $this->markOrderUnpaid($order, 'cancelled', 'failed'),
            default => null,
        };

        return response('OK');
    }

    /**
     * Resolve the user the order belongs to.
     */
    private function resolveUser(array $validated): User
    {
        $authenticated = Auth::user();

        if ($authenticated !== null) {
            return $authenticated;
        }

        if (User::where('email', $validated['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => __('This email is already registered. Please log in to place your order.'),
            ]);
        }

        if (User::where('phone', $validated['phone'])->exists()) {
            throw ValidationException::withMessages([
                'phone' => __('This phone number is already registered with another email address.'),
            ]);
        }

        try {
            return User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['phone']),
                'address' => $validated['delivery_address'],
            ]);
        } catch (QueryException) {
            if (User::where('email', $validated['email'])->exists()) {
                throw ValidationException::withMessages([
                    'email' => __('This email is already registered. Please log in to place your order.'),
                ]);
            }

            throw ValidationException::withMessages([
                'phone' => __('This phone number is already registered with another email address.'),
            ]);
        }
    }

    /**
     * Log the user in after a successful guest checkout.
     *
     */
    private function loginOrCreateUser(User $user): bool
    {
        if (Auth::check() || ! $user->wasRecentlyCreated) {
            return false;
        }

        Auth::login($user);

        return true;
    }

    /**
     * Log a guest in after their online payment succeeds.
     */
    private function loginCheckoutUser(Order $order): void
    {
        if (Auth::check()) {
            return;
        }

        $fresh = $order->fresh();

        if ($fresh === null || $fresh->payment_status !== 'paid' || $fresh->user_id === null) {
            return;
        }

        $user = User::query()->whereKey($fresh->user_id)->first();

        if ($user === null || $user->created_at === null || $fresh->created_at === null) {
            return;
        }

        if (abs($user->created_at->diffInMinutes($fresh->created_at)) > 30) {
            return;
        }

        if ($user->orders()->whereKeyNot($fresh->id)->exists()) {
            return;
        }

        Auth::login($user);
    }

    private function validatedCheckoutData(Request $request): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20', new BangladeshiPhoneNumber],
            'delivery_address' => ['required', 'string'],
            'terms' => ['accepted'],
        ]);
    }

    private function totals(): array
    {
        return [
            'shipping' => $this->shippingTotal(),
            'total' => LaraCart::total(false),
            'tax' => LaraCart::taxTotal(false),
            'items' => LaraCart::getItems(),
        ];
    }

    private function createOrder(User $user, array $validated, array $totals, string $paymentType, ?string $transactionId = null): Order
    {
        return DB::transaction(function () use ($user, $validated, $totals, $paymentType, $transactionId): Order {
            $order = Order::create([
                'user_id' => $user->id,
                'order_total' => $totals['total'],
                'tax_total' => $totals['tax'],
                'shipping_total' => $totals['shipping'],
                'order_status' => 'pending',
                'delivery_address' => $validated['delivery_address'],
                'delivery_status' => 'pending',
                'payment_type' => $paymentType,
                'payment_status' => 'pending',
                'currency' => 'BDT',
                'transaction_id' => $transactionId,
            ]);

            foreach ($totals['items'] as $item) {
                $product = Product::query()->whereKey($item->id)->lockForUpdate()->first();

                if ($product === null || $product->status !== 'published') {
                    throw ValidationException::withMessages([
                        'product' => __(':product is no longer available.', ['product' => $item->name]),
                    ]);
                }

                if ($product->stock_amount < $item->qty) {
                    throw ValidationException::withMessages([
                        'product' => __('Only :count :product available in stock.', [
                            'count' => $product->stock_amount,
                            'product' => $item->name,
                        ]),
                    ]);
                }

                $product->decrement('stock_amount', $item->qty);

                $order->details()->create([
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'product_price' => $item->price,
                    'product_quantity' => $item->qty,
                ]);
            }

            return $order;
        });
    }

    private function markOrderPaid(string $tranId, string $valId, float $amount): bool
    {
        $order = $this->orderByTransactionId($tranId);

        if ($order === null || $order->payment_status === 'paid') {
            return false;
        }

        $validation = app(SslCommerzService::class)->validate($valId);

        if (! $this->validationMatches($order, $validation, $amount)) {
            return false;
        }

        DB::transaction(function () use ($order): void {
            $locked = Order::query()->whereKey($order->id)->lockForUpdate()->first();

            if ($locked === null || $locked->payment_status === 'paid') {
                return;
            }

            $locked->update([
                'order_status' => 'processing',
                'payment_status' => 'paid',
            ]);
        });

        return true;
    }

    private function markOrderUnpaid(Order $order, string $orderStatus, string $paymentStatus): void
    {
        DB::transaction(function () use ($order, $orderStatus, $paymentStatus): void {
            $locked = Order::query()->whereKey($order->id)->lockForUpdate()->first();

            if ($locked === null || $locked->order_status !== 'pending' || $locked->payment_status !== 'pending') {
                return;
            }

            $locked->update([
                'order_status' => $orderStatus,
                'payment_status' => $paymentStatus,
            ]);

            $this->restoreOrderStock($locked);
        });
    }

    private function restoreOrderStock(Order $order): void
    {
        foreach ($order->details as $detail) {
            Product::query()->whereKey($detail->product_id)->increment('stock_amount', $detail->product_quantity);
        }
    }

    private function validationMatches(Order $order, array $validation, float $amount): bool
    {
        $status = $validation['status'] ?? null;
        $validAmount = (float) ($validation['amount'] ?? 0);
        $validTranId = $validation['tran_id'] ?? null;

        return in_array($status, ['VALID', 'VALIDATED'], true)
            && $validTranId === $order->transaction_id
            && abs($validAmount - $amount) < 0.01
            && abs($validAmount - (float) $order->order_total) < 0.01;
    }

    private function verifySignature(Request $request): bool
    {
        $verifyKey = $request->string('verify_key')->toString();
        $verifySign = $request->string('verify_sign')->toString();

        if ($verifyKey === '' || $verifySign === '') {
            return false;
        }

        return app(SslCommerzService::class)->verifySignature($verifyKey, $verifySign, $request->all());
    }

    private function orderByTransactionId(string $tranId): ?Order
    {
        return $tranId === '' ? null : Order::query()->where('transaction_id', $tranId)->first();
    }

    private function newTransactionId(): string
    {
        return 'SSLCZ'.uniqid();
    }

    private function shippingTotal(): float
    {
        LaraCart::addFee('shipping', 20);

        return LaraCart::getFee('shipping')?->getAmount(false) ?? 0;
    }
}
