<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Database\Factories\SubCategoryFactory;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SubCategoryFactory::STAR_TECH_SUB_CATEGORIES as $categoryName => $names) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($names as $name) {
                SubCategory::firstOrCreate([
                    'category_id' => $category->getKey(),
                    'name' => $name,
                ]);
            }
        }

        $this->command?->info('Seeded '.SubCategory::query()->count().' sub-categories.');
    }
}
