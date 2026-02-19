<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Sponsor;
use Illuminate\Database\Seeder;

class SponsorEventSeeder extends Seeder {
    public function run(): void {
        $sponsors = [
            ['name' => 'Tech Corp', 'logo' => 'https://via.placeholder.com/150x50?text=Tech+Corp', 'link' => 'https://example.com'],
            ['name' => 'Nature Foundation', 'logo' => 'https://via.placeholder.com/150x50?text=Nature+Foundation', 'link' => 'https://example.com'],
            ['name' => 'Art Gallery', 'logo' => 'https://via.placeholder.com/150x50?text=Art+Gallery', 'link' => 'https://example.com'],
        ];

        foreach ($sponsors as $s) {
            Sponsor::updateOrCreate(['name' => $s['name']], $s);
        }

        $events = [
            [
                'title'       => 'Annual Cultural Night 2026',
                'slug'        => 'annual-cultural-night-2026',
                'description' => '<p>Join us for an unforgettable evening of music, dance, and cultural celebration. Featuring local artists and community performers.</p>',
                'image'       => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3',
                'start_date'  => '2026-03-25',
                'end_date'    => '2026-03-26',
                'location'    => 'Main Auditorium, Dhaka',
                'is_active'   => true,
            ],
            [
                'title'       => 'Tree Plantation Campaign',
                'slug'        => 'tree-plantation-campaign',
                'description' => '<p>Help us make the city greener. We are planting 1000 saplings this weekend. Everyone is welcome to join!</p>',
                'image'       => 'https://images.unsplash.com/photo-1542601906970-d4d812ed9e3c',
                'start_date'  => '2026-02-28',
                'end_date'    => '2026-02-28',
                'location'    => 'Ramna Park',
                'is_active'   => true,
            ],
            [
                'title'       => 'Past Event (Hidden)',
                'slug'        => 'past-event-hidden',
                'description' => '<p>This event should be hidden on frontend because it is in the past.</p>',
                'image'       => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4',
                'start_date'  => '2023-01-01',
                'end_date'    => '2023-01-02',
                'location'    => 'Old Campus',
                'is_active'   => true,
            ],
        ];

        foreach ($events as $e) {
            Event::updateOrCreate(['slug' => $e['slug']], $e);
        }
    }
}
