<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->word,
            'icon' => '<i class="fas fa-tv"></i>',
            'image' => 'categories/' . $this->faker->picsum(storage_path('app/public/categories'), 640, 480, null, false)
        ];
    }
}
