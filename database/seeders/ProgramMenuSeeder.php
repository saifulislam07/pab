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
        // Admin Menu Parent
        $parent = Menu::updateOrCreate(
            ['title' => 'Program Setup', 'type' => 'admin'],
            [
                'url'       => null,
                'icon'      => 'fas fa-calendar-alt',
                'position'  => 150,
                'is_active' => true,
            ]
        );

        // Manage Programs Child
        Menu::updateOrCreate(
            ['title' => 'Manage Programs', 'type' => 'admin'],
            [
                'url'       => 'admin/programs',
                'parent_id' => $parent->id,
                'icon'      => 'fas fa-list',
                'position'  => 1,
                'is_active' => true,
            ]
        );

        // Frontend Menu (remains top level or as desired)

        // Frontend Menu
        Menu::updateOrCreate(
            ['url' => 'programs', 'type' => 'frontend'],
            [
                'title'     => 'Programs',
                'position'  => 50,
                'is_active' => true,
            ]
        );
    }
}
