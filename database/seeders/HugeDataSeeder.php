<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Member;
use App\Models\Sponsor;
use Illuminate\Database\Seeder;

class HugeDataSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // 1. Categories
        $categories = Category::factory()->count(10)->create();

        // 2. Gallery Items (associated with categories)
        GalleryItem::factory()->count(100)->recycle($categories)->create();

        // 3. Events
        Event::factory()->count(100)->create();

        // 4. Members
        Member::factory()->count(50)->create();

        // 5. Advertisements
        Advertisement::factory()->count(30)->create();

        // Ensure some active ones for today
        Advertisement::factory()->count(10)->create([
            'start_date' => now()->subDays(5),
            'end_date'   => now()->addDays(20),
            'is_active'  => true,
            'position'   => 'banner',
        ]);

        Advertisement::factory()->count(10)->create([
            'start_date' => now()->subDays(5),
            'end_date'   => now()->addDays(20),
            'is_active'  => true,
            'position'   => 'sidebar',
        ]);

        // 6. Sponsors
        Sponsor::factory()->count(20)->create();
    }
}
