<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Frontend Menus
        $frontendMenus = [
            ['title' => 'Home', 'url' => '/', 'position' => 0, 'type' => 'frontend'],
            ['title' => 'About', 'url' => '/about', 'position' => 1, 'type' => 'frontend'],
            ['title' => 'Mission & Vision', 'url' => '/mission-vision', 'position' => 2, 'type' => 'frontend'],
            ['title' => 'Team', 'url' => '/team', 'position' => 3, 'type' => 'frontend'],
            ['title' => 'Members', 'url' => '/members', 'position' => 4, 'type' => 'frontend'],
            ['title' => 'Events', 'url' => '/events', 'position' => 5, 'type' => 'frontend'],
            ['title' => 'Registration', 'url' => '/register', 'position' => 6, 'type' => 'frontend'],
            ['title' => 'Gallery', 'url' => '/gallery', 'position' => 7, 'type' => 'frontend'],
            ['title' => 'Contact', 'url' => '/contact', 'position' => 8, 'type' => 'frontend'],
        ];

        foreach ($frontendMenus as $menu) {
            Menu::updateOrCreate(['title' => $menu['title'], 'type' => 'frontend'], $menu);
        }

        // Admin Sidebar Menus
        $adminMenus = [
            ['title' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'fas fa-tachometer-alt', 'position' => 0, 'type' => 'admin'],
            ['title' => 'Sliders', 'url' => 'admin/sliders', 'icon' => 'fas fa-images', 'position' => 1, 'type' => 'admin'],
            ['title' => 'About Us', 'url' => 'admin/about', 'icon' => 'fas fa-info-circle', 'position' => 2, 'type' => 'admin'],
            ['title' => 'Mission & Vision', 'url' => 'admin/mission-vision', 'icon' => 'fas fa-bullseye', 'position' => 3, 'type' => 'admin'],
            ['title' => 'Gallery Management', 'url' => 'admin/gallery', 'icon' => 'far fa-image', 'position' => 4, 'type' => 'admin'],
            ['title' => 'Categories', 'url' => 'admin/categories', 'icon' => 'fas fa-list', 'position' => 5, 'type' => 'admin'],
            ['title' => 'Team Management', 'url' => 'admin/team', 'icon' => 'fas fa-users', 'position' => 6, 'type' => 'admin'],
            ['title' => 'Member Approval', 'url' => 'admin/members', 'icon' => 'fas fa-user-check', 'position' => 7, 'type' => 'admin'],
            ['title' => 'Sponsors', 'url' => 'admin/sponsors', 'icon' => 'fas fa-handshake', 'position' => 8, 'type' => 'admin'],
            ['title' => 'Events/News', 'url' => 'admin/events', 'icon' => 'fas fa-calendar-alt', 'position' => 9, 'type' => 'admin'],
            ['title' => 'Advertisements', 'url' => 'admin/advertisements', 'icon' => 'fas fa-ad', 'position' => 10, 'type' => 'admin'],
            ['title' => 'Menu Management', 'url' => 'admin/menus', 'icon' => 'fas fa-bars', 'position' => 11, 'type' => 'admin'],
            ['title' => 'User Management', 'url' => 'admin/users', 'icon' => 'fas fa-user-shield', 'position' => 12, 'type' => 'admin'],
            ['title' => 'Roles Management', 'url' => 'admin/roles', 'icon' => 'fas fa-user-tag', 'position' => 13, 'type' => 'admin'],
            ['title' => 'Permissions', 'url' => 'admin/permissions', 'icon' => 'fas fa-key', 'position' => 14, 'type' => 'admin'],
            ['title' => 'Site Settings', 'url' => 'admin/settings', 'icon' => 'fas fa-cog', 'position' => 15, 'type' => 'admin'],
            ['title' => 'SMTP Settings', 'url' => 'admin.settings.smtp', 'icon' => 'fas fa-envelope', 'position' => 16, 'type' => 'admin'],
        ];

        foreach ($adminMenus as $menu) {
            Menu::updateOrCreate(['title' => $menu['title'], 'type' => 'admin'], $menu);
        }

        // Member Menus
        $memberMenus = [
            ['title' => 'My Dashboard', 'url' => 'member/dashboard', 'icon' => 'fas fa-tachometer-alt', 'position' => 0, 'type' => 'member'],
            ['title' => 'My Profile', 'url' => 'member/profile/complete', 'icon' => 'fas fa-user-circle', 'position' => 1, 'type' => 'member'],
            ['title' => 'Events', 'url' => 'events', 'icon' => 'fas fa-calendar-alt', 'position' => 2, 'type' => 'member'],
            ['title' => 'Gallery', 'url' => 'gallery', 'icon' => 'fas fa-images', 'position' => 3, 'type' => 'member'],
        ];

        foreach ($memberMenus as $menu) {
            Menu::updateOrCreate(['title' => $menu['title'], 'type' => 'member'], $menu);
        }
    }
}
