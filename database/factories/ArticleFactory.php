<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title'             => $title,
            'slug'              => Str::slug($title),
            'body'              => $this->faker->paragraphs(3, true),
            'thumbnail'         => null,
            'user_id'           => User::factory(),
            'category_id'       => Category::factory(),
            'is_hero'           => false,
            'is_editors_choice' => false,
            'views'             => 0,
        ];
    }
}