<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_name'      => 'PAB',
                'site_title'     => 'Photography Association Bangladesh',
                'footer_text'    => 'Uniting photographers, inspiring creativity, and capturing the essence of Bangladesh. Join our community to explore the art of visual storytelling.',
                'contact_email'  => 'info@pab.org.bd',
                'contact_phone'  => '+880 1234 567890',
                'address'        => 'Dhaka, Bangladesh',
                'facebook_link'  => 'https://facebook.com/pab',
                'twitter_link'   => 'https://twitter.com/pab',
                'instagram_link' => 'https://instagram.com/pab',
                'linkedin_link'  => 'https://linkedin.com/company/pab',
            ]
        );
    }
}
