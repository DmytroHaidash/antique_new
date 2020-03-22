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
            'categories' => ProductCategories::paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product_categories.create');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var ProductCategories $product_category */
        $product_category = new ProductCategories;
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
        return \view('admin.product_categories.edit', compact('product_category'));
    }

    /**
     * @param  Request  $request
     * @param  ProductCategories  $product_category
     * @return RedirectResponse
     */
    public function update(Request $request, ProductCategories $product_category): RedirectResponse
    {
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
