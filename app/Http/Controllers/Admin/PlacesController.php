<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceSavingRequest;
use App\Models\Place;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PlacesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.places.index', [
            'places' => Place::latest()->paginate(25)
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.places.create');
    }

    /**
     * @param  PlaceSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(PlaceSavingRequest $request): RedirectResponse
    {
        $place = new Place();
        $place->makeTranslation(['title', 'body'])->save();

        return redirect()->route('admin.places.edit', $place)->with('message', 'Место проведения добавлено.');
    }

    /**
     * @param  Place  $place
     * @return View
     */
    public function edit(Place $place): View
    {
        return view('admin.places.edit', compact('place'));
    }

    /**
     * @param  PlaceSavingRequest  $request
     * @param  Place  $place
     * @return RedirectResponse
     */
    public function update(PlaceSavingRequest $request, Place $place): RedirectResponse
    {
        $place->makeTranslation(['title', 'body'])->save();

        return back()->with('message', 'Место проведения обновлено.');
    }

    /**
     * @param  Place  $place
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Place $place): RedirectResponse
    {
        $place->delete();

        return back()->with('message', 'Место проведения удалено.');
    }
}
