<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            MenuSeeder::class,
            SettingSeeder::class,
            AboutSeeder::class,
            MissionVisionSeeder::class,
            SliderSeeder::class,
            AdminSeeder::class,
            RolesAndPermissionsSeeder::class,
            \Database\Seeders\SponsorEventSeeder::class,
            HugeDataSeeder::class,
            DistrictSeeder::class,
        ]);

        // Seed Members
        $roles = ['President', 'Secretary', 'Treasurer', 'Member'];
        // Seed Members
        $roles = ['President', 'Secretary', 'Treasurer', 'Member'];
        for ($i = 1; $i <= 10; $i++) {
            $user = \App\Models\User::firstOrCreate(
                ['email' => 'member' . $i . '@example.com'],
                [
                    'name'     => 'Member ' . $i,
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role'     => 'member',
                ]
            );

            \App\Models\Member::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'email'  => $user->email,
                    'name'   => $user->name,
                    'role'   => $roles[array_rand($roles)],
                    'image'  => 'https://i.pravatar.cc/150?img=' . $i,
                    'bio'    => 'Passionate photographer with a love for capturing moments.',
                    'status' => 'approved',
                ]
            );
        }

        // Seed Categories first if they don't exist
        $categoryNames = ['Nature', 'Urban', 'Portrait', 'Event'];
        $categoryIds = [];
        foreach ($categoryNames as $name) {
            $cat = \App\Models\Category::firstOrCreate(['name' => $name], ['slug' => \Illuminate\Support\Str::slug($name)]);
            $categoryIds[] = $cat->id;
        }

        // Seed Gallery Items
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
                'title'       => 'Gallery Item',
                'image'       => $img,
                'category_id' => $categoryIds[array_rand($categoryIds)],
            ]);
        }
    }
}
