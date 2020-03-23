<?php

namespace App\Http\Controllers\Client;

use App\Models\Page;
use App\Models\Post;
use App\Models\ProductCategories;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(): View
    {
        $posts = Post::take(6)->get();
        $sections = ProductCategories::onlyParents()->get();
        $banner = Page::where('slug', 'about')->first();

        return view('client.home.index', compact('posts', 'sections', 'banner'));
    }
}
