<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use LukePOLO\LaraCart\Facades\LaraCart;

class CartController extends Controller
{
    public function index(): View
    {
        $this->syncTaxRate();

        if (LaraCart::count() > 0) {
            LaraCart::addFee('shipping', 20);
        } else {
            LaraCart::removeFee('shipping');
        }

        return view('frontend.carts.index', [
            'items' => LaraCart::getItems(),
            'subTotal' => LaraCart::subTotal(false),
            'taxTotal' => LaraCart::taxTotal(false),
            'shipping' => LaraCart::getFee('shipping')?->getAmount(false) ?? 0,
            'total' => LaraCart::total(false),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $product = $this->saleableProduct($validated['product_id']) ?? abort(404);

        if ($validated['quantity'] > $product->stock_amount) {
            NotificationService::error(__('Only :count items available in stock.', ['count' => $product->stock_amount]));

            return back();
        }

        LaraCart::add($product->id, $product->name, $validated['quantity'], (float) $product->selling_amount, ['image' => $product->featured_image]);
        NotificationService::created(__('Product added to cart.'));

        return redirect()->route('cart.index');
    }

    public function update(Request $request, string $cart): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $item = LaraCart::getItem($cart);
        abort_if($item === null, 404);

        if ($validated['quantity'] === 0) {
            return $this->remove($cart, __('Product removed from cart.'));
        }

        $product = $this->saleableProduct($item->id);

        if ($product === null) {
            return $this->remove($cart, __('This product is no longer available.'));
        }

        if ($validated['quantity'] > $product->stock_amount) {
            NotificationService::error(__('Only :count items available in stock.', ['count' => $product->stock_amount]));

            return back();
        }

        LaraCart::updateItem($cart, 'qty', $validated['quantity']);
        NotificationService::updated(__('Cart updated.'));

        return redirect()->route('cart.index');
    }

    public function destroy(string $cart): RedirectResponse
    {
        abort_if(LaraCart::getItem($cart) === null, 404);

        return $this->remove($cart, __('Product removed from cart.'));
    }

    public function clear(): RedirectResponse
    {
        LaraCart::emptyCart();
        NotificationService::deleted(__('Cart cleared.'));

        return redirect()->route('cart.index');
    }

    private function remove(string $hash, string $message): RedirectResponse
    {
        LaraCart::removeItem($hash);
        NotificationService::deleted($message);

        return redirect()->route('cart.index');
    }

    /**
     * Items keep the tax rate from when they were added, so refresh them
     * to the current configured rate before totals are shown.
     */
    private function syncTaxRate(): void
    {
        $rate = config('laracart.tax');
        $changed = false;

        foreach (LaraCart::getItems() as $item) {
            if ($item->tax !== $rate) {
                $item->tax = $rate;
                $changed = true;
            }
        }

        if ($changed) {
            LaraCart::update();
        }
    }

    private function saleableProduct(int|string $id): ?Product
    {
        return Product::query()->whereKey($id)->where('status', 'published')->first();
    }
}
