<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder {
    public function run(): void {
        About::updateOrCreate(
            ['id' => 1],
            [
                'title'           => 'Capture Life Through Our Lens',
                'description'     => 'The Photography Association of Bangladesh (PAB) is more than just an organization; it is a vibrant community dedicated to the art and craft of photography.',
                'our_story'       => 'Founded with a passion for visual storytelling, we have grown into a premier hub for photographers across the nation, providing education, inspiration, and a platform for creative expression.',
                'image_main'      => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d',
                'image_secondary' => 'https://images.unsplash.com/photo-1542382156909-9ae37b3f56fd',
                'stats_years'     => '10+',
                'stats_members'   => '1000+',
                'stats_workshops' => '200+',
                'stats_awards'    => '75+',
            ]
        );
    }
}
