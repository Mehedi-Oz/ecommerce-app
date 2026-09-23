<?php

namespace Database\Seeders;

use App\Models\Brand;
use Database\Factories\BrandFactory;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (BrandFactory::STAR_TECH_BRANDS as $name) {
            Brand::firstOrCreate(['name' => $name]);
        }

        $this->command?->info('Seeded '.Brand::query()->count().' brands.');
    }
}
