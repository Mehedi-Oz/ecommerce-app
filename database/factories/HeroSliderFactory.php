<?php

namespace Database\Factories;

use App\Models\HeroSlider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSlider>
 */
class HeroSliderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'subtitle' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'price_text' => '৳ '.$this->faker->randomFloat(2, 100, 2000),
            'button_text' => 'Shop Now',
            'button_url' => '/products',
            'background_image' => null,
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
