<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Category;
use App\Models\Laminating;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'usertype' => 'admin',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'usertype' => 'user',
            'password' => 'password'
        ]);

        Category::create([
            'name' => 'kat1',
            'image' => '#'
        ]);

        Bahan::create([
            'name' => 'racing',
        ]);
        Bahan::create([
            'name' => 'sport',
        ]);

        Laminating::create([
            'name' => 'kat1',
        ]);
        Laminating::create([
            'name' => 'kat2',
        ]);
    }
}
