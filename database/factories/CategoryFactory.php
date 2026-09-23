<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use OverflowException;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Real top-level categories from https://www.startech.com.bd/.
     *
     * @var array<int, string>
     */
    public const STAR_TECH_CATEGORIES = [
        'Desktop',
        'Laptop',
        'Component',
        'Monitor',
        'Power',
        'Phone',
        'Tablet',
        'Office Equipment',
        'Camera',
        'Security',
        'Networking',
        'Software',
        'Server & Storage',
        'Accessories',
        'Gadget',
        'Gaming',
        'TV',
        'Appliance',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => static::uniqueStarTechName(),
            'description' => fake()->sentence(),
            'status' => 'published',
            'is_featured' => false,
        ];
    }

    protected static function uniqueStarTechName(): string
    {
        $available = array_values(array_diff(
            static::STAR_TECH_CATEGORIES,
            Category::query()->pluck('name')->all()
        ));

        if ($available !== []) {
            try {
                return fake()->unique()->randomElement($available);
            } catch (OverflowException) {
                // Fall through to a generated name below.
            }
        }

        try {
            return fake()->unique()->words(2, true);
        } catch (OverflowException) {
            return fake()->unique()->bothify('Category-####');
        }
    }
}
