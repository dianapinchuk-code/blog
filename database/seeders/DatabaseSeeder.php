<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            BlogCategoriesTableSeeder::class,
        ]);

        BlogPost::factory(100)->create();
    }
}
