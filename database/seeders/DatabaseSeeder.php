<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Post::factory(20)->create();

        User::find(1)->update([
            'name' => 'Andre',
            'email' => 'andre@andre.com',
        ]);
    }
}
