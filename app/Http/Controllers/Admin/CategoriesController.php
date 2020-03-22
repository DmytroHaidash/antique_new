<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorySavingRequest;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Str;

class CategoriesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = Category::onlyParents()->withCount('posts')->orderBy('title->ru')->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::onlyParents()->orderBy('title->ru')->get();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * @param  CategorySavingRequest  $request
     * @return RedirectResponse
     */
    public function store(CategorySavingRequest $request): RedirectResponse
    {
        $category = new Category($request->only('parent_id'));
        $category->makeTranslation(['title', 'description'])->save();

        if ($request->hasFile('cover')) {
            $category->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * @param  Category  $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $categories = Category::onlyParents()->orderBy('title->ru')->where('id', '!=', $category->id)->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * @param  CategorySavingRequest  $request
     * @param  Category  $category
     * @return RedirectResponse
     */
    public function update(CategorySavingRequest $request, Category $category)
    {
        $category->parent_id = $request->input('parent_id');
        $category->makeTranslation(['title', 'description'])->save();

        if ($request->hasFile('cover')) {
            $category->clearMediaCollection('cover');
            $category->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * @param  Category  $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->posts->count()) {
            return back()->withErrors('Нельзя удалять категорию, в которой есть записи.');
        }

        $category->delete();

        return back()->with('message', 'Категория успешно удалена');
    }
}
