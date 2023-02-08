<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => 1,
            'name' => $this->faker->word,
            'slug' => Str::slug($this->faker->word),
            'color' => false,
            'image' => 'subcategories/' . $this->faker->picsum(storage_path('app/public/subcategories'), 640, 480, null, false)
        ];
    }
}
