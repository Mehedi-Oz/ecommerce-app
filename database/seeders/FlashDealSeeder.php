<?php

namespace Database\Seeders;

use App\Models\FlashDeal;
use App\Models\Product;
use Illuminate\Database\Seeder;

class FlashDealSeeder extends Seeder
{
    public function run(): void
    {
        if (FlashDeal::query()->active()->exists()) {
            return;
        }

        $product = Product::query()->published()->orderByDesc('id')->first();

        if ($product === null) {
            return;
        }

        FlashDeal::create([
            'product_id' => $product->id,
            'sale_price' => max(0, (float) $product->selling_amount * 0.5),
            'ends_at' => now()->addDays(7),
            'is_active' => true,
        ]);
    }
}
