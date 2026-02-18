<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryItemSeeder extends Seeder {
    public function run(): void {
        // Clear existing items
        GalleryItem::truncate();

        $nature = Category::where('slug', 'nature')->first();
        $urban = Category::where('slug', 'urban')->first();
        $portrait = Category::where('slug', 'portrait')->first();
        $people = Category::where('slug', 'people')->first();
        $astronomy = Category::where('slug', 'astronomy')->first();

        $items = [
            ['title' => 'Mist Over Mountains', 'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b', 'category_id' => $nature->id],
            ['title' => 'Golden Hour Forest', 'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e', 'category_id' => $nature->id],
            ['title' => 'City Lights at Night', 'image' => 'https://images.unsplash.com/photo-1477346611705-65d1883cee1e', 'category_id' => $urban->id],
            ['title' => 'Neon Streets', 'image' => 'https://images.unsplash.com/photo-1493238792000-8113da705763', 'category_id' => $urban->id],
            ['title' => 'Soulful Portrait', 'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2', 'category_id' => $portrait->id],
            ['title' => 'Traditional Attire', 'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d', 'category_id' => $people->id],
            ['title' => 'Village Life', 'image' => 'https://images.unsplash.com/photo-1506466010722-395ee2bef877', 'category_id' => $people->id],
            ['title' => 'Starry Night Skyscape', 'image' => 'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a', 'category_id' => $astronomy->id],
        ];

        foreach ($items as $item) {
            GalleryItem::create($item);
        }
    }
}
