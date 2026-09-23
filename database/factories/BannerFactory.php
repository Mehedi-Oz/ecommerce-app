<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'location' => $this->faker->randomElement(Banner::LOCATIONS),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'button_text' => 'Shop Now',
            'button_url' => '/products',
            'image' => null,
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
