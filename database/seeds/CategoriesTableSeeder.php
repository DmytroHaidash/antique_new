<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'title' => 'Наши проекты',
                'slug' => 'projects'
            ],
            [
                'title' => 'СМИ',
                'slug' => 'mass-media'
            ],
            [
                'title' => 'Публикации',
                'slug' => 'publications'
            ],
            [
                'title' => 'Новости',
                'slug' => 'news'
            ],
            [
                'title' => 'Фотоотчеты',
                'slug' => 'proto-reports'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'slug' => $category['slug'],
                'title' => ['ru' => $category['title']]
            ]);
        }
    }
}
