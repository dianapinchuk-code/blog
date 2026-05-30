<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [];

        $categories[] = [
            'title' => 'Без категорії',
            'slug' => Str::slug('Без категорії'),
            'parent_id' => 0,
        ];

        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'title' => 'Категорія #' . $i,
                'slug' => Str::slug('Категорія #' . $i),
                'parent_id' => ($i > 4) ? rand(1, 4) : 1,
            ];
        }

        DB::table('blog_categories')->insert($categories);
    }
}
