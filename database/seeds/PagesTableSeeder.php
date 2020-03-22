<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = require_once __DIR__.'/../datasets/pages.php';

        foreach ($pages as $page) {
            $newPage = new Page([
                'slug' => $page['slug'] ?? SlugService::createSlug(Page::class, 'slug', $page['title']['ru'])
            ]);

            foreach (config('app.locales') as $locale) {
                $newPage->setTranslation('title', $locale, $page['title'][$locale])
                    ->setTranslation('body', $locale, $page['body'][$locale]);
            }

            $newPage->save();
        }
    }
}
