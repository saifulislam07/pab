<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MembershipMenuSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Admin Membership Menu
        Menu::updateOrCreate(
            ['url' => 'admin/membership'],
            [
                'title'     => 'Membership Requests',
                'icon'      => 'fas fa-id-card',
                'type'      => 'admin',
                'is_active' => 1,
                'position'  => 150,
            ]
        );

        // Member Membership Menu
        Menu::updateOrCreate(
            ['url' => 'member/membership'],
            [
                'title'     => 'Membership',
                'icon'      => 'fas fa-id-card',
                'type'      => 'member',
                'is_active' => 1,
                'position'  => 50,
            ]
        );
    }
}
