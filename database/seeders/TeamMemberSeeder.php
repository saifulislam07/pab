<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder {
    public function run(): void {
        $members = [
            ['name' => 'Rahim Ahmed', 'role' => 'President', 'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d', 'order' => 1],
            ['name' => 'Fatima Begum', 'role' => 'Vice President', 'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330', 'order' => 2],
            ['name' => 'Kamal Hossain', 'role' => 'Secretary', 'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e', 'order' => 3],
            ['name' => 'Nasima Akter', 'role' => 'Treasurer', 'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80', 'order' => 4],
            ['name' => 'Tanvir Rahman', 'role' => 'Creative Director', 'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e', 'order' => 5],
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }
}
