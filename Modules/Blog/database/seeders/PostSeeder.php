<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'Welcome to My Blog!',
            'body' => 'This is the first post created by the seeder. You can edit or delete it once your site is live.',
            'tag' => 'general',
            'feature_image' => null,
            'user_id' => 1,
        ]);
    }
}
