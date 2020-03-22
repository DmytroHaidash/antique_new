<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $category = null;
        $posts = Post::query();

        if ($request->input('category')) {
            $category = Category::where('slug', $request->input('category'))->first();
            $posts = $posts->whereHas('categories', function (Builder $builder) use ($category) {
                $builder->where('id', $category->id);
            });
        }

        return view('client.blog.index', [
            'posts' => $posts->paginate(12),
            'categories' => Category::has('posts')->get(),
            'current' => $category
        ]);
    }

    /**
     * @param  Post  $post
     * @return View
     */
    public function show(Post $post): View
    {
        return view('client.blog.show', compact('post'));
    }
}
