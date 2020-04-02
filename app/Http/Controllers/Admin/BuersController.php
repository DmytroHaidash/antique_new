<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BuersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.buers.index', [
            'buers' => Buer::paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.buers.create');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var Buer $buer */
        $buer = Buer::create(['title' => $request->input('title')]);

        return redirect()->route('admin.buers.index');
    }

    /**
     * @param  Buer $buer
     * @return View
     */
    public function edit(Buer $buer): View
    {
        return \view('admin.buers.edit', compact('buer'));
    }

    /**
     * @param  Request  $request
     * @param  Buer $buer
     * @return RedirectResponse
     */
    public function update(Request $request, Buer $buer): RedirectResponse
    {
        /** @var Buer $buer */
        $buer = $buer->update(['title' => $request->input('title')]);

        return redirect()->route('admin.buers.index');
    }

    /**
     * @param Buer $buer
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Buer $buer): RedirectResponse
    {
        $buer->delete();
        return redirect()->route('admin.buers.index');
    }
}
