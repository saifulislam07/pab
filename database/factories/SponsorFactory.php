<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsor>
 */
class SponsorFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name'      => $this->faker->company,
            'logo'      => 'https://via.placeholder.com/150x50?text=' . urlencode($this->faker->company),
            'link'      => $this->faker->url,
            'order'     => $this->faker->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
