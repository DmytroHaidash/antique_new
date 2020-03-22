<?php

use App\Models\Category;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = require __DIR__.'/../datasets/posts.php';

        foreach ($posts as $key => $items) {
            /** @var Category $category */
            $category = Category::where('slug', $key)->first();

            foreach ($items as $post) {
                $category->posts()->create([
                    'slug' => SlugService::createSlug(Post::class, 'slug', $post['title']['ru']),
                    'title' => $post['title'],
                    'body' => $post['body']
                ]);
            }
        }
    }
}
