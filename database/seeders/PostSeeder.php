<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Hamara Test User
        $categories = Category::all();

        foreach ($categories as $category) {
            // Har category mein 2 random posts dalte hain
            for ($i = 1; $i <= 2; $i++) {
                $title = "Latest news in " . $category->name . " Part " . $i;
                Post::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'content' => "Ye hamara API-based blog ka content hai for " . $category->name,
                    'status' => 'published',
                    'is_premium' => rand(0, 1),
                ]);
            }
        }
    }
}
