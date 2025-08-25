<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->paragraph(1, 3);

        return [
            'title' => $title,
            'description' => fake()->paragraph(2, 6),
            'image' => 'post-images/example.jpeg',
            'slug' => Str::slug($title),
            'user_id' => User::factory(),
            // "comment_id" => Comment::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
