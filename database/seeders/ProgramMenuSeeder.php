<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class ProgramMenuSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Admin Menu
        Menu::updateOrCreate(
            ['url' => 'admin.programs.index', 'type' => 'admin'],
            [
                'title'     => 'Programs',
                'icon'      => 'fas fa-calendar-alt',
                'position'  => 150,
                'is_active' => true,
            ]
        );

        // Frontend Menu
        Menu::updateOrCreate(
            ['url' => 'programs.index', 'type' => 'frontend'],
            [
                'title'     => 'Programs',
                'position'  => 50,
                'is_active' => true,
            ]
        );
    }
}
