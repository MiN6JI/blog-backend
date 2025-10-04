<?php

namespace Modules\Blog\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'mingji@gmail.com'],
            [
                'name' => 'Mingji',
                'password' => Hash::make('M1N6JI##16')
            ],
        );
    }
}
