<?php

namespace App\Http\Controllers\Admin;

use App\Models\Accounting;
use App\Models\Buer;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\Status;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Spatie\MediaLibrary\Models\Media;

class ProductsController extends Controller
{
    /**
     * @param  Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tags = collect([]);
        $products = Product::with(['categories']);
        if ($request->filled('product_category')) {
            $ids = explode(',', $request->input('product_category'));
            $tags = ProductCategories::whereIn('slug', $ids)->get();
            $products = $products->whereHas('categories', function (Builder $q) use ($ids) {
                $q->whereIn('slug', $ids);
            });
        }

        if ($request->filled('q')) {
            $query = $request->input('q');
            $products = $products->where('title', 'like', "%{$query}%");
        }

        return \view('admin.products.index', [
            'products' => $products->paginate(20),
            'tags' => $tags,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.products.create', [
            'categories' => ProductCategories::onlyParents()->get(),
            'statuses' => Status::get(),
            'suppliers' => Supplier::get(),
            'buers' => Buer::get(),
        ]);
    }

    /**
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var Product $product */
        $product = new Product([
            'price' => $request->input('price'),
            'is_published' => $request->has('is_published'),
            'in_stock' => $request->input('in_stock'),
            'publish_price' => $request->has('publish_price'),
        ]);
        $product->makeTranslation(['title', 'description', 'body'])->save();
        $product->categories()->attach($request->input('categories', []));

        $this->handleMedia($request, $product);
        if ($request->has('meta')) {
            foreach ($request->get('meta') as $key => $meta) {
                $product->meta()->updateOrCreate([
                    'metable_id' => $product->id
                ], [
                    $key => $meta
                ]);
            }
        }
        if ($request->has('accountings')) {
            $supplier = $request['accountings']['supplier_id'];
            $buer = $request['accountings']['buer_id'];
            if($request['new-supplier']){
                $supplier = Supplier::create(['title' => $request->input('new-supplier')]);
                $supplier = $supplier->id;
            }
            if($request['new-buer']){
                $buer = Buer::create(['title' => $request->input('new-buer')]);
                $buer = $buer->id;
            }

            $product->accountings()->create([
                'date' => $request['accountings']['date'],
                'status' => $request['accountings']['status_id'],
                'supplier' => $supplier,
                'whom' => $request['accountings']['whom'],
                'price' => json_encode($request['accountings']['price']),
                'message' => json_encode($request['accountings']['message']),
                'amount' => $request['accountings']['amount'],
                'comment' => $request['accountings']['comment'],
                'buer_id' => $buer,
                'sell_price' => $request['accountings']['sell_price'],
                'sell_date' => $request['accountings']['sell_date']
            ]);
            if ($request->has('accounting')) {
                foreach ($request->accounting as $media) {
                    Media::find($media)->update([
                        'model_type' => Accounting::class,
                        'model_id' => $product->accountings->id,
                    ]);
                }
                Media::setNewOrder($request->input('accounting'));
            }
        }
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * @param  Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return \view('admin.products.edit', [
            'product' => $product,
            'categories' => ProductCategories::onlyParents()->get(),
            'statuses' => Status::get(),
            'suppliers' => Supplier::get(),
            'buers' => Buer::get(),
        ]);
    }

    /**
     * @param  Request $request
     * @param  Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
//        dd($request->has('new-supplier'));
        $product->fill([
            'price' => $request->input('price'),
            'is_published' => $request->has('is_published'),
            'in_stock' => $request->input('in_stock'),
            'publish_price' => $request->has('publish_price'),
        ]);
        $product->makeTranslation(['title', 'description', 'body'])->save();
        $product->categories()->sync($request->input('categories'));
        $this->handleMedia($request, $product);
        if ($request->has('meta')) {
            foreach ($request->get('meta') as $key => $meta) {
                $product->meta()->updateOrCreate([
                    'metable_id' => $product->id
                ], [
                    $key => $meta
                ]);
            }
        }

        if ($request->has('accountings')) {
            $supplier = $request['accountings']['supplier_id'];
            $buer = $request['accountings']['buer_id'];
            if($request['new-supplier']){
                dd($supplier);
                $supplier = Supplier::create(['title' => $request->input('new-supplier')]);
                $supplier = $supplier->id;
            }
            if($request['new-supplier']){
                $buer = Buer::create(['title' => $request->input('new-buer')]);
                $buer = $buer->id;
            }
            if($product->accountings){
                $product->accountings->update([
                    'date' => $request['accountings']['date'],
                    'status_id' => $request['accountings']['status_id'],
                    'supplier_id' => $supplier,
                    'whom' => $request['accountings']['whom'],
                    'price' => json_encode($request['accountings']['price']),
                    'message' => json_encode($request['accountings']['message']),
                    'amount' => $request['accountings']['amount'],
                    'comment' => $request['accountings']['comment'],
                    'buer_id' => $buer,
                    'sell_price' => $request['accountings']['sell_price'],
                    'sell_date' => $request['accountings']['sell_date']
                ]);
            }else{
                $product->accountings()->create([
                    'date' => $request['accountings']['date'],
                    'status' => $request['accountings']['status_id'],
                    'supplier' => $supplier,
                    'whom' => $request['accountings']['whom'],
                    'price' => json_encode($request['accountings']['price']),
                    'message' => json_encode($request['accountings']['message']),
                    'amount' => $request['accountings']['amount'],
                    'comment' => $request['accountings']['comment'],
                    'buer_id' => $buer,
                    'sell_price' => $request['accountings']['sell_price'],
                    'sell_date' => $request['accountings']['sell_date']
                ]);
            }
            if ($request->has('accounting')) {
                foreach ($request->accounting as $media) {
                    Media::find($media)->update([
                        'model_type' => Accounting::class,
                        'model_id' => $product->accountings->id,
                    ]);
                }
                Media::setNewOrder($request->input('accounting'));
            }
        }
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index');
    }

    /**
     * @param  Product $item
     * @return RedirectResponse
     */
    public function up(Product $item)
    {
        $item->moveOrderUp();

        return back();
    }

    /**
     * @param  Product $item
     * @return RedirectResponse
     */
    public function down(Product $item)
    {
        $item->moveOrderDown();

        return back();
    }

    /**
     * @param  Request $request
     * @param  Product $product
     */
    private function handleMedia(Request $request, Product $product): void
    {
        if ($request->filled('uploads')) {
            foreach ($request->input('uploads') as $media) {
                Media::find($media)->update([
                    'model_type' => Product::class,
                    'model_id' => $product->id
                ]);
            }

            Media::setNewOrder($request->input('uploads'));
        }

        if ($request->filled('deletion')) {
            Media::whereIn('id', $request->input('deletion'))->delete();
        }
    }
}
