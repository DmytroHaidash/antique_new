<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProductCategoriesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.product_categories.index', [
            'categories' => ProductCategories::onlyParents()->paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = ProductCategories::onlyParents()->get();
        return \view('admin.product_categories.create', compact('categories'));
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var ProductCategories $product_category */
        $product_category = new ProductCategories($request->only('parent_id'));
        $product_category->makeTranslation(['title'])->save();

        if ($request->hasFile('cover')) {
            $product_category->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }
        return redirect()->route('admin.product_categories.edit', $product_category);
    }

    /**
     * @param  ProductCategories  $product_category
     * @return View
     */
    public function edit(ProductCategories $product_category): View
    {
        $categories = ProductCategories::onlyParents()->where('id', '!=', $product_category->id)->get();
        return \view('admin.product_categories.edit', compact('product_category', 'categories'));
    }

    /**
     * @param  Request  $request
     * @param  ProductCategories  $product_category
     * @return RedirectResponse
     */
    public function update(Request $request, ProductCategories $product_category): RedirectResponse
    {
        $product_category->fill($request->only('parent_id'));
        $product_category->makeTranslation(['title'])->save();
        if ($request->hasFile('cover')) {
            $product_category->clearMediaCollection('cover');
            $product_category->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }
        return redirect()->route('admin.product_categories.edit', $product_category);
    }

    /**
     * @param ProductCategories $product_category
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(ProductCategories $product_category): RedirectResponse
    {
        $product_category->delete();
        return redirect()->route('admin.product_categories.index');
    }

    /**
     * @param  ProductCategories $item
     * @return RedirectResponse
     */
    public function up(ProductCategories $item)
    {
        $item->moveOrderUp();

        return back();
    }

    /**
     * @param  ProductCategories $item
     * @return RedirectResponse
     */
    public function down(ProductCategories $item)
    {
        $item->moveOrderDown();

        return back();
    }
}
