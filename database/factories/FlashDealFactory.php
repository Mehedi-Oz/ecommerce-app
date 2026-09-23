<?php

namespace Database\Factories;

use App\Models\FlashDeal;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FlashDeal>
 */
class FlashDealFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'sale_price' => $this->faker->randomFloat(2, 100, 1000),
            'ends_at' => now()->addDays(7),
            'is_active' => true,
        ];
    }
}
