<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryItem>
 */
class GalleryItemFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'title'       => $this->faker->words(3, true),
            'image'       => 'https://images.unsplash.com/photo-' . $this->faker->randomElement([
                '1502472584286-8235545f3335', '1509316975850-ff9c5deb0cd9', '1542382156909-9ae37b3f56fd',
                '1518495973542-4542c06a5843', '1472214103451-9374bd1c7dd1', '1469334031218-e382a71b716b',
                '1452587925148-ce544e77e70d', '1447752875215-b2761acb3c5d', '1464822759023-fed622ff2c3b',
            ]) . '?auto=format&fit=crop&q=80&w=800',
            'category_id' => Category::factory(),
        ];
    }
}
