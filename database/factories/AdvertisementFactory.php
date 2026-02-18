<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = (clone $startDate)->modify('+' . rand(7, 30) . ' days');

        return [
            'title'      => $this->faker->sentence(3),
            'image'      => 'https://via.placeholder.com/' . ($this->faker->boolean ? '728x90' : '300x250') . '?text=Ad+' . $this->faker->word,
            'link'       => $this->faker->url,
            'price'      => $this->faker->randomFloat(2, 50, 500),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date'   => $endDate->format('Y-m-d'),
            'position'   => $this->faker->randomElement(['sidebar', 'banner']),
            'is_active'  => true,
        ];
    }
}
