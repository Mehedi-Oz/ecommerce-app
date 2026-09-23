<?php

namespace Database\Seeders;

use App\Models\Unit;
use Database\Factories\UnitFactory;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UnitFactory::STAR_TECH_UNITS as $name => $code) {
            Unit::firstOrCreate(['name' => $name], ['code' => $code]);
        }

        $this->command?->info('Seeded '.Unit::query()->count().' units.');
    }
}
