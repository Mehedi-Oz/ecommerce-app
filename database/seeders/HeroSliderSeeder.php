<?php

namespace Database\Seeders;

use App\Models\HeroSlider;
use Illuminate\Database\Seeder;

class HeroSliderSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'subtitle' => 'No restocking fee (৳ 35 savings)',
                'title' => 'M75 Sport Watch',
                'description' => 'Track your heart rate, steps, and sleep to stay on top of your fitness goals every single day.',
                'price_text' => '৳ 320.99',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'background_image' => 'assets/frontend/images/hero/slider-bg1.jpg',
                'sort_order' => 0,
            ],
            [
                'subtitle' => 'Big Sale Offer',
                'title' => 'Get the Best Deal on CCTV Camera',
                'description' => 'Keep your home and family safe with crystal clear day and night surveillance.',
                'price_text' => '৳ 590.00',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'background_image' => 'assets/frontend/images/hero/slider-bg2.jpg',
                'sort_order' => 1,
            ],
        ];

        foreach ($rows as $row) {
            HeroSlider::firstOrCreate(
                ['title' => $row['title']],
                $row + ['is_active' => true]
            );
        }
    }
}
