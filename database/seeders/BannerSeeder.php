<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'location' => 'hero_sidebar_top',
                'title' => 'iPhone 18 Pro Max',
                'description' => 'New line required',
                'button_text' => null,
                'button_url' => '/products',
                'image' => 'assets/frontend/images/hero/slider-bnr.jpg',
            ],
            [
                'location' => 'hero_sidebar_bottom',
                'title' => 'Weekly Sale!',
                'description' => 'Saving up to 50% off all online store items this week.',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'image' => null,
            ],
            [
                'location' => 'mid_left',
                'title' => 'Smart Watch 2.0',
                'description' => 'Space Gray Aluminum Case with Black/Volt Real Sport Band',
                'button_text' => 'View Details',
                'button_url' => '/products',
                'image' => 'assets/frontend/images/banner/banner-1-bg.jpg',
            ],
            [
                'location' => 'mid_right',
                'title' => 'Smart Headphone',
                'description' => 'Immerse yourself in rich, crystal clear sound with deep bass.',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'image' => 'assets/frontend/images/banner/banner-2-bg.jpg',
            ],
            [
                'location' => 'special_banner',
                'title' => 'Samsung Notebook 9',
                'description' => 'Work anywhere with all day battery life and a stunning display.',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'image' => 'assets/frontend/images/banner/banner-3-bg.jpg',
            ],
        ];

        foreach ($rows as $order => $row) {
            Banner::firstOrCreate(
                ['location' => $row['location'], 'title' => $row['title']],
                $row + ['sort_order' => $order, 'is_active' => true]
            );
        }
    }
}
