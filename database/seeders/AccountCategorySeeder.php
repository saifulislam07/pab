<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $categories = [
            ['name' => 'Program Registration Fee', 'type' => 'income', 'icon' => 'fas fa-id-badge'],
            ['name' => 'General Donation', 'type' => 'income', 'icon' => 'fas fa-hand-holding-usd'],
            ['name' => 'Sponsorship', 'type' => 'income', 'icon' => 'fas fa-handshake'],
            ['name' => 'Office Rent', 'type' => 'expense', 'icon' => 'fas fa-building'],
            ['name' => 'Electricity Bill', 'type' => 'expense', 'icon' => 'fas fa-lightbulb'],
            ['name' => 'Event Logistics', 'type' => 'expense', 'icon' => 'fas fa-boxes'],
            ['name' => 'Travel & Transport', 'type' => 'expense', 'icon' => 'fas fa-bus'],
            ['name' => 'Marketing & Printing', 'type' => 'expense', 'icon' => 'fas fa-print'],
            ['name' => 'Miscellaneous', 'type' => 'expense', 'icon' => 'fas fa-tags'],
        ];

        foreach ($categories as $cat) {
            \App\Models\AccountCategory::updateOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
