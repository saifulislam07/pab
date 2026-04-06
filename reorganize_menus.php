<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;

// 1. Update/Configure "Programs" (ID 31 existing)
$programsParent = Menu::find(31);
if ($programsParent) {
    $programsParent->update([
        'title' => 'Program Management',
        'icon' => 'fas fa-layer-group',
        'position' => 10,
        'url' => null,
    ]);
} else {
    // Fallback if not found
    $programsParent = Menu::updateOrCreate(
        ['title' => 'Program Management', 'type' => 'admin'],
        ['icon' => 'fas fa-layer-group', 'position' => 10, 'url' => null]
    );
}

// 2. Create "Content Management" Parent
$contentParent = Menu::updateOrCreate(
    ['title' => 'Content Management', 'type' => 'admin', 'parent_id' => null],
    ['icon' => 'fas fa-edit', 'position' => 20, 'url' => null, 'is_active' => true]
);

// 3. Create "Information" Parent
$infoParent = Menu::updateOrCreate(
    ['title' => 'Information', 'type' => 'admin', 'parent_id' => null],
    ['icon' => 'fas fa-info-circle', 'position' => 30, 'url' => null, 'is_active' => true]
);

// 4. Create "System Settings" Parent
$systemParent = Menu::updateOrCreate(
    ['title' => 'System Settings', 'type' => 'admin', 'parent_id' => null],
    ['icon' => 'fas fa-cogs', 'position' => 40, 'url' => null, 'is_active' => true]
);

// --- Move Children ---

// Under Programs (ID: $programsParent->id)
Menu::whereIn('id', [32, 17, 18, 19])->update(['parent_id' => $programsParent->id]);
// Note: ID 19 is Events/News, maybe move to content? Let's move it to content instead.

// Under Content (ID: $contentParent->id)
Menu::whereIn('id', [11, 14, 15, 19, 20])->update(['parent_id' => $contentParent->id]);

// Under Information (ID: $infoParent->id)
Menu::whereIn('id', [12, 13, 16])->update(['parent_id' => $infoParent->id]);

// Under System (ID: $systemParent->id)
Menu::whereIn('id', [21, 22, 23, 24, 25, 26])->update(['parent_id' => $systemParent->id]);

// --- Refine Positions inside groups ---
$positions = [
    // Programs
    32 => 1, // Manage Programs
    17 => 2, // Member Approval
    18 => 3, // Sponsors
    // Content
    11 => 1, // Sliders
    14 => 2, // Gallery Management
    15 => 3, // Categories
    19 => 4, // Events/News
    20 => 5, // Advertisements
    // Information
    12 => 1, // About Us
    13 => 2, // Mission & Vision
    16 => 3, // Team Management
    // System
    22 => 1, // User Management
    23 => 2, // Roles Management
    24 => 3, // Permissions
    25 => 4, // Site Settings
    26 => 5, // SMTP Settings
    21 => 6, // Menu Management
];

foreach ($positions as $id => $pos) {
    Menu::where('id', $id)->update(['position' => $pos]);
}

echo "Admin menus reorganized successfully!\n";
