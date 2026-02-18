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
            'name'     => $this->faker->name,
            'role'     => $this->faker->randomElement(['President', 'Secretary', 'Treasurer', 'General Member', 'advisor', 'Volunteer']),
            'image'    => 'https://i.pravatar.cc/300?u=' . $this->faker->uuid,
            'bio'      => $this->faker->paragraph,
            'facebook' => 'https://facebook.com/' . $this->faker->userName,
            'twitter'  => 'https://twitter.com/' . $this->faker->userName,
            'linkedin' => 'https://linkedin.com/in/' . $this->faker->userName,
            'status'   => 'approved',
        ];
    }
}
