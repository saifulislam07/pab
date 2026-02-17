<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed Members
        $roles = ['President', 'Secretary', 'Treasurer', 'Member'];
        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Member::create([
                'name'  => 'Member ' . $i,
                'role'  => $roles[array_rand($roles)],
                'image' => 'https://i.pravatar.cc/150?img=' . $i,
                'bio'   => 'Passionate photographer with a love for capturing moments.',
            ]);
        }

        // Seed Gallery Items
        $categories = ['Nature', 'Urban', 'Portrait', 'Event'];
        $images = [
            'https://images.unsplash.com/photo-1502472584286-8235545f3335',
            'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9',
            'https://images.unsplash.com/photo-1542382156909-9ae37b3f56fd',
            'https://images.unsplash.com/photo-1518495973542-4542c06a5843',
            'https://images.unsplash.com/photo-1472214103451-9374bd1c7dd1',
            'https://images.unsplash.com/photo-1469334031218-e382a71b716b',
            'https://images.unsplash.com/photo-1452587925148-ce544e77e70d',
            'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d',
        ];

        foreach ($images as $img) {
            \App\Models\GalleryItem::create([
                'title'    => 'Gallery Item',
                'image'    => $img,
                'category' => $categories[array_rand($categories)],
            ]);
        }
    }
}
