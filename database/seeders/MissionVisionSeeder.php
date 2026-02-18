<?php

namespace Database\Seeders;

use App\Models\MissionVision;
use Illuminate\Database\Seeder;

class MissionVisionSeeder extends Seeder {
    public function run(): void {
        MissionVision::updateOrCreate(
            ['id' => 1],
            [
                'title'               => 'Our Identity & Purpose',
                'subtitle'            => 'Defining our journey in the world of photography',
                'mission_title'       => 'Our Mission',
                'mission_description' => 'To empower photographers in Bangladesh by providing them with the tools, knowledge, and community they need to excel in their craft.',
                'mission_points'      => ['Education & Workshops', 'Networking Opportunities', 'Exhibition Platforms', 'Skill Development'],
                'mission_image'       => 'https://images.unsplash.com/photo-1502472584286-8235545f3335',
                'vision_title'        => 'Our Vision',
                'vision_description'  => 'To be the leading catalyst for the transformation of photography into a widely recognized and respected art form in South Asia.',
                'vision_points'       => ['Global Recognition', 'Technological Innovation', 'Cultural Preservation'],
                'vision_image'        => 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9',
                'core_values'         => [
                    [
                        'title' => 'Creativity',
                        'desc'  => 'We celebrate and nurture original thought and artistic expression.',
                        'icon'  => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.364-6.364l-.707-.707M6.733 17c.096.317.07.659-.073.951L6 19h12l-.66-1.049c-.144-.292-.17-.634-.073-.951C17.843 15.532 19 13.896 19 12a7 7 0 10-14 0c0 1.896 1.157 3.532 2.733 5z',
                    ],
                    [
                        'title' => 'Integrity',
                        'desc'  => 'We uphold the highest standards of professional ethics.',
                        'icon'  => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    ],
                    [
                        'title' => 'Community',
                        'desc'  => 'We believe in the power of collaboration and mutual support.',
                        'icon'  => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                    ],
                    [
                        'title' => 'Excellence',
                        'desc'  => 'We strive for the highest quality in every photograph.',
                        'icon'  => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
                    ],
                ],
            ]
        );
    }
}
