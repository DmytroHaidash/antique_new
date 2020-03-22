<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorSavingRequest;
use App\Models\Author;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Str;

class AuthorsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $authors = Author::orderBy('name->ru')->withCount(['exhibits', 'publications'])->paginate(20);

        return view('admin.authors.index', compact('authors'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.authors.create');
    }

    /**
     * @param  AuthorSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(AuthorSavingRequest $request): RedirectResponse
    {
        $author = new Author($request->only('lives_from', 'lives_to'));
        $author->makeTranslation(['name', 'biography'])->save();

        if ($request->hasFile('cover')) {
            $author->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.authors.edit', $author);
    }

    /**
     * @param  Author  $author
     * @return View
     */
    public function edit(Author $author): View
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * @param  AuthorSavingRequest  $request
     * @param  Author  $author
     * @return RedirectResponse
     */
    public function update(AuthorSavingRequest $request, Author $author): RedirectResponse
    {
        $author->fill($request->only('lives_from', 'lives_to'));
        $author->makeTranslation(['name', 'biography'])->save();

        if ($request->hasFile('cover')) {
            $author->clearMediaCollection('cover');
            $author->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.authors.edit', $author);
    }

    /**
     * @param  Author  $author
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();

        return back();
    }
}
