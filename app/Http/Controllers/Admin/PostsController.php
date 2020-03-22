<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostSavingRequest;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Str;

class PostsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $posts = Post::query();
        if (request()->filled('q')) {
            $q = request()->input('q');
            $posts->where('title', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%")->orWhere('body', 'like', "%{$q}%");
        }

        return view('admin.posts.index', [
            'posts' => $posts->latest()->paginate(20)
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::onlyParents()->orderBy('title->ru')->get();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * @param  PostSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(PostSavingRequest $request): RedirectResponse
    {
        /** @var Post $post */
        $post = (new Post())->fill([
            'published_at' => Carbon::parse($request->input('published_at')),
            'published' => $request->has('published'),
            'video' => $request->input('video')
        ]);

        $post->makeTranslation(['title', 'description', 'body'])->save();
        $post->categories()->attach($request->input('category_id'));

        if ($request->hasFile('cover')) {
            $post->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }
        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $post->meta()->updateOrCreate([
                    'metable_id' => $post->id
                ], [
                    $key => $meta
                ]);
            }
        }

        return redirect()->route('admin.posts.edit', $post)->with('message', 'Запись успешно создана.');
    }

    /**
     * @param  Post  $post
     * @return View
     */
    public function edit(Post $post): View
    {
        $categories = Category::onlyParents()->with('children')->orderBy('title->ru')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * @param  PostSavingRequest  $request
     * @param  Post  $post
     * @return RedirectResponse
     */
    public function update(PostSavingRequest $request, Post $post): RedirectResponse
    {

        $post->fill([
            'published_at' => Carbon::parse($request->input('published_at')),
            'published' => $request->has('published'),
            'video' => $request->input('video')
        ]);

        $post->makeTranslation(['title', 'description', 'body'])->save();
        $post->categories()->sync($request->input('category_id'));

        if ($request->hasFile('cover')) {
            $post->clearMediaCollection('cover');
            $post->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }
        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $post->meta()->updateOrCreate([
                    'metable_id' => $post->id
                ], [
                    $key => $meta
                ]);
            }
        }
        return redirect()->route('admin.posts.edit', $post)->with('message', 'Запись успешно обновлена.');
    }

    /**
     * @param  Post  $post
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return back();
    }
}
