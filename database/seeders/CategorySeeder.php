<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CategoryFactory::STAR_TECH_CATEGORIES as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        $this->command?->info('Seeded '.Category::query()->count().' categories.');
    }
}
