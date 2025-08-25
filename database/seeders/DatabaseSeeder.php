<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'riski123',
            'email' => 'riski123@gmail.com',
            'password' => bcrypt('riski123'),
        ]);

        User::factory()->create([
            'username' => 'agus123',
            'email' => 'agus123@gmail.com',
            'password' => bcrypt('agus123'),
        ]);

        User::factory()->create([
            'username' => 'ucup123',
            'email' => 'ucup123@gmail.com',
            'password' => bcrypt('ucup123'),
        ]);

        User::factory()->create([
            'username' => 'admin123',
            'email' => 'admin123@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        Category::create([
            'name' => 'Nature',
            'slug' => 'nature',
        ]);

        Category::create([
            'name' => 'Person',
            'slug' => 'person',
        ]);

        Category::create([
            'name' => 'Family',
            'slug' => 'family',
        ]);

        Category::create([
            'name' => 'Pet',
            'slug' => 'pet',
        ]);

        Category::create([
            'name' => 'Science',
            'slug' => 'science',
        ]);

        Category::create([
            'name' => 'Education',
            'slug' => 'education',
        ]);

        Category::create([
            'name' => 'Art',
            'slug' => 'art',
        ]);

        Category::create([
            'name' => 'Comic',
            'slug' => 'comic',
        ]);

        // User::factory(10)->has(
        //     Post::factory()->count(3)->for(
        //         Category::factory()
        //     )
        // )->create();

    }
}
