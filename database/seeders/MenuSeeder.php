<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder {
    public function run(): void {
        // Clear existing menus
        Menu::truncate();

        // --- FRONTEND MENUS ---
        $frontendMenus = [
            ['title' => 'Home', 'url' => 'home', 'icon' => 'fas fa-home'],
            ['title' => 'About', 'url' => 'about', 'icon' => 'fas fa-info-circle'],
            ['title' => 'Events', 'url' => 'events.index', 'icon' => 'fas fa-calendar-alt'],
            ['title' => 'Programs', 'url' => 'programs.index', 'icon' => 'fas fa-tasks'],
            ['title' => 'Gallery', 'url' => 'gallery', 'icon' => 'fas fa-images'],
            ['title' => 'Contact', 'url' => 'contact', 'icon' => 'fas fa-envelope'],
        ];

        foreach ($frontendMenus as $index => $item) {
            Menu::create([
                'title'     => $item['title'],
                'url'       => $item['url'],
                'icon'      => $item['icon'],
                'type'      => 'frontend',
                'target'    => '_self',
                'position'  => $index,
                'is_active' => true,
            ]);
        }

        // --- ADMIN SIDEBAR MENUS ---
        
        // 1. Dashboard (Standalone)
        Menu::create([
            'title'     => 'Dashboard',
            'url'       => 'admin.dashboard',
            'icon'      => 'fas fa-tachometer-alt',
            'type'      => 'admin',
            'target'    => '_self',
            'position'  => 0,
            'is_active' => true,
        ]);

        // 2. User Management (Group)
        $userMgmt = Menu::create([
            'title'     => 'User Management',
            'url'       => null,
            'icon'      => 'fas fa-users-cog',
            'type'      => 'admin',
            'target'    => '_self',
            'position'  => 1,
            'is_active' => true,
        ]);

        $userMgmtItems = [
            ['title' => 'Users', 'url' => 'admin.users.index', 'icon' => 'fas fa-user'],
            ['title' => 'Roles', 'url' => 'admin.roles.index', 'icon' => 'fas fa-user-tag'],
            ['title' => 'Permissions', 'url' => 'admin.permissions.index', 'icon' => 'fas fa-key'],
            ['title' => 'All Members', 'url' => 'admin.members.index', 'icon' => 'fas fa-id-card'],
            ['title' => 'Pending Approval', 'url' => 'admin.membership.index', 'icon' => 'fas fa-user-clock'],
        ];

        foreach ($userMgmtItems as $index => $item) {
            Menu::create([
                'title'     => $item['title'],
                'url'       => $item['url'],
                'icon'      => $item['icon'],
                'parent_id' => $userMgmt->id,
                'type'      => 'admin',
                'target'    => '_self',
                'position'  => $index,
                'is_active' => true,
            ]);
        }

        // 3. Financials (Group)
        $finance = Menu::create([
            'title'     => 'Financials',
            'url'       => null,
            'icon'      => 'fas fa-file-invoice-dollar',
            'type'      => 'admin',
            'target'    => '_self',
            'position'  => 2,
            'is_active' => true,
        ]);

        $financeItems = [
            ['title' => 'Categories', 'url' => 'admin.finance.categories', 'icon' => 'fas fa-tags'],
            ['title' => 'Income Tracker', 'url' => 'admin.finance.income', 'icon' => 'fas fa-hand-holding-usd'],
            ['title' => 'Expense Tracker', 'url' => 'admin.finance.expense', 'icon' => 'fas fa-money-bill-wave'],
            ['title' => 'Financial Report', 'url' => 'admin.finance.report', 'icon' => 'fas fa-chart-line'],
        ];

        foreach ($financeItems as $index => $item) {
            Menu::create([
                'title'     => $item['title'],
                'url'       => $item['url'],
                'icon'      => $item['icon'],
                'parent_id' => $finance->id,
                'type'      => 'admin',
                'target'    => '_self',
                'position'  => $index,
                'is_active' => true,
            ]);
        }

        // 4. Portfolio Works (Group)
        $portfolio = Menu::create([
            'title'     => 'Portfolio Assets',
            'url'       => null,
            'icon'      => 'fas fa-briefcase',
            'type'      => 'admin',
            'target'    => '_self',
            'position'  => 3,
            'is_active' => true,
        ]);

        $portfolioItems = [
            ['title' => 'Programs', 'url' => 'admin.programs.index', 'icon' => 'fas fa-tasks'],
            ['title' => 'Events', 'url' => 'admin.events.index', 'icon' => 'fas fa-calendar-alt'],
            ['title' => 'Gallery Management', 'url' => 'admin.gallery.index', 'icon' => 'fas fa-images'],
            ['title' => 'Sponsors', 'url' => 'admin.sponsors.index', 'icon' => 'fas fa-handshake'],
            ['title' => 'Sliders', 'url' => 'admin.sliders.index', 'icon' => 'fas fa-film'],
        ];

        foreach ($portfolioItems as $index => $item) {
            Menu::create([
                'title'     => $item['title'],
                'url'       => $item['url'],
                'icon'      => $item['icon'],
                'parent_id' => $portfolio->id,
                'type'      => 'admin',
                'target'    => '_self',
                'position'  => $index,
                'is_active' => true,
            ]);
        }

        // 5. System Settings (Group)
        $settings = Menu::create([
            'title'     => 'System Settings',
            'url'       => null,
            'icon'      => 'fas fa-cogs',
            'type'      => 'admin',
            'target'    => '_self',
            'position'  => 4,
            'is_active' => true,
        ]);

        $settingsItems = [
            ['title' => 'General Settings', 'url' => 'admin.settings.edit', 'icon' => 'fas fa-sliders-h'],
            ['title' => 'Email Configuration', 'url' => 'admin.settings.smtp', 'icon' => 'fas fa-at'],
            ['title' => 'Dynamic Menus', 'url' => 'admin.menus.index', 'icon' => 'fas fa-bars'],
            ['title' => 'Mission & Vision', 'url' => 'admin.mission-vision.edit', 'icon' => 'fas fa-eye'],
            ['title' => 'About Content', 'url' => 'admin.about.edit', 'icon' => 'fas fa-address-card'],
            ['title' => 'Team Profile', 'url' => 'admin.team.index', 'icon' => 'fas fa-users'],
        ];

        foreach ($settingsItems as $index => $item) {
            Menu::create([
                'title'     => $item['title'],
                'url'       => $item['url'],
                'icon'      => $item['icon'],
                'parent_id' => $settings->id,
                'type'      => 'admin',
                'target'    => '_self',
                'position'  => $index,
                'is_active' => true,
            ]);
        }
    }
}
