<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SuppliersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.suppliers.index', [
            'suppliers' => Supplier::paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.suppliers.create');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var Supplier $supplier */
        $supplier = Supplier::create(['title' => $request->input('title')]);

        return redirect()->route('admin.suppliers.index');
    }

    /**
     * @param  Supplier $supplier
     * @return View
     */
    public function edit(Supplier $supplier): View
    {
        return \view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * @param  Request  $request
     * @param  Supplier $supplier
     * @return RedirectResponse
     */
    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        /** @var Supplier $supplier */
        $supplier = $supplier->update(['title' => $request->input('title')]);

        return redirect()->route('admin.suppliers.index');
    }


    /**
     * @param Supplier $supplier
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers.index');
    }
}
