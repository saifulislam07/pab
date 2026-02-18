<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder {
    public function run(): void {
        $sliders = [
            [
                'title'    => 'Master the Art of Photography',
                'subtitle' => 'Learn from the best and capture the extraordinary.',
                'image'    => 'https://images.unsplash.com/photo-1518495973542-4542c06a5843',
                'order'    => 1,
            ],
            [
                'title'    => 'Join a Community of Visionaries',
                'subtitle' => 'Share your work and inspire others across the globe.',
                'image'    => 'https://images.unsplash.com/photo-1472214103451-9374bd1c7dd1',
                'order'    => 2,
            ],
            [
                'title'    => 'Explore the Beauty of Bangladesh',
                'subtitle' => 'Document the rich culture and landscapes through your lens.',
                'image'    => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b',
                'order'    => 3,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(['title' => $slider['title']], $slider);
        }
    }
}
