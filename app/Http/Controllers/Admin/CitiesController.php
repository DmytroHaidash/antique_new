<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CitySavingRequest;
use App\Models\City;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CitiesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.cities.index', [
            'cities' => City::withCount('exhibitions')->paginate(20)
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.cities.create');
    }

    /**
     * @param  CitySavingRequest  $request
     * @return RedirectResponse
     */
    public function store(CitySavingRequest $request): RedirectResponse
    {
        $city = new City(['country' => 'UA']);
        $city->makeTranslation(['name'])->save();

        return redirect()->route('admin.cities.edit', $city)->with('message', 'Город успешно добавлен.');
    }

    /**
     * @param  City  $city
     * @return View
     */
    public function edit(City $city): View
    {
        return view('admin.cities.edit', compact('city'));
    }

    /**
     * @param  CitySavingRequest  $request
     * @param  City  $city
     * @return View
     */
    public function update(CitySavingRequest $request, City $city): View
    {
        $city->makeTranslation(['name'])->save();

        return redirect()->route('admin.cities.edit', $city)->with('message', 'Город успешно обновлен.');
    }
}
