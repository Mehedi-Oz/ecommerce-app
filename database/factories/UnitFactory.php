<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use OverflowException;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Units commonly used by https://www.startech.com.bd/ sold items.
     *
     * @var array<string, string>
     */
    public const STAR_TECH_UNITS = [
        'Piece' => '1_piece',
        'Box' => '1_box',
        'Set' => '1_set',
        'Pair' => '1_pair',
        'Dozen' => '1_dozen',
        'Carton' => '1_carton',
        'Pack' => '1_pack',
        'Kilogram' => '1_kg',
        'Meter' => '1_meter',
        'Liter' => '1_liter',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => static::uniqueName(),
            'code' => fn (array $attributes) => static::STAR_TECH_UNITS[$attributes['name']] ?? '1_unit',
            'description' => fake()->sentence(),
            'status' => 'published',
        ];
    }

    protected static function uniqueName(): string
    {
        $available = array_values(array_diff(
            array_keys(static::STAR_TECH_UNITS),
            Unit::query()->pluck('name')->all()
        ));

        if ($available !== []) {
            try {
                return fake()->unique()->randomElement($available);
            } catch (OverflowException) {
                // Fall through to a generated name below.
            }
        }

        try {
            return fake()->unique()->word();
        } catch (OverflowException) {
            return fake()->unique()->bothify('Unit-####');
        }
    }
}
