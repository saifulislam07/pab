<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $title = $this->faker->sentence(4);
        $startDate = $this->faker->dateTimeBetween('-1 month', '+6 months');
        $endDate = (clone $startDate)->modify('+' . rand(0, 3) . ' days');

        return [
            'title'       => $title,
            'slug'        => Str::slug($title),
            'description' => '<p>' . implode('</p><p>', $this->faker->paragraphs(3)) . '</p>',
            'image'       => 'https://images.unsplash.com/photo-' . $this->faker->randomElement([
                '1533174072545-7a4b6ad7a6c3', '1542601906970-d4d812ed9e3c', '1501281668745-f7f57925c3b4',
                '1492684223066-81342ee5ff30', '1511795409834-ef04bbd61622', '1475721027785-f7497ec08105',
            ]) . '?auto=format&fit=crop&q=80&w=800',
            'event_date'  => $startDate->format('Y-m-d'),
            'start_date'  => $startDate->format('Y-m-d'),
            'end_date'    => $endDate->format('Y-m-d'),
            'location'    => $this->faker->city . ', ' . $this->faker->country,
            'is_active'   => true,
        ];
    }
}
