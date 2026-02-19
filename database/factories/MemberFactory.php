<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'user_id'          => \App\Models\User::factory(),
            'name'             => $this->faker->name,
            'title'            => $this->faker->randomElement(['Lead Photographer', 'Cinematographer', 'Portrait Specialist', 'Nature Photographer', 'Freelancer']),
            'mobile'           => $this->faker->phoneNumber,
            'email'            => $this->faker->unique()->safeEmail,
            'role'             => $this->faker->randomElement(['President', 'Secretary', 'Treasurer', 'General Member', 'advisor', 'Volunteer']),
            'image'            => 'https://i.pravatar.cc/300?u=' . $this->faker->uuid,
            'bio'              => $this->faker->paragraph,
            'division'         => $this->faker->randomElement(['Dhaka', 'Chittagong', 'Rajshahi', 'Sylhet', 'Khulna']),
            'district'         => $this->faker->city,
            'upazila'          => $this->faker->streetName,
            'current_location' => $this->faker->address,
            'specialization'   => $this->faker->randomElement(['Wedding', 'Wildlife', 'Fashion', 'Sports', 'Street']),
            'experience_level' => $this->faker->randomElement(['Professional', 'Intermediate', 'Hobbyist']),
            'camera_gear'      => $this->faker->sentence,
            'facebook'         => 'https://facebook.com/' . $this->faker->userName,
            'instagram'        => 'https://instagram.com/' . $this->faker->userName,
            'linkedin'         => 'https://linkedin.com/in/' . $this->faker->userName,
            'website'          => $this->faker->url,
            'status'           => 'approved',
        ];
    }
}
