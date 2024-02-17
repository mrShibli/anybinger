<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StaticPage>
 */
class StaticPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'slug' => fake()->slug,
            'description' => fake()->paragraph,
            'meta_keyword' => fake()->words(4,true),
            'meta_description' => fake()->paragraph,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
