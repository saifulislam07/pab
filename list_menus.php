<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$menus = \App\Models\Menu::orderBy('type')->orderBy('position')->get();
foreach ($menus as $menu) {
    echo "ID: {$menu->id} | Type: {$menu->type} | Title: {$menu->title} | Position: {$menu->position} | Parent: {$menu->parent_id}\n";
}
