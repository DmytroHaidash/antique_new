<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitionSavingRequest;
use App\Models\City;
use App\Models\Exhibition;
use App\Models\Place;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ExhibitionsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $exhibitions = Exhibition::orderByDesc('starts_at')->paginate(20);

        return view('admin.exhibitions.index', compact('exhibitions'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $cities = City::all();
        $places = Place::all();

        return view('admin.exhibitions.create', compact('cities', 'places'));
    }

    /**
     * @param  ExhibitionSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(ExhibitionSavingRequest $request): RedirectResponse
    {
        $exhibition = new Exhibition($this->handleAttributes($request));
        $exhibition->makeTranslation(['title', 'description', 'body'])->save();

        if ($request->hasFile('cover')) {
            $exhibition->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.exhibitions.edit', $exhibition);
    }

    /**
     * @param  Exhibition  $exhibition
     * @return View
     */
    public function edit(Exhibition $exhibition): View
    {
        $cities = City::all();
        $places = Place::all();

        return view('admin.exhibitions.edit', compact('exhibition', 'cities', 'places'));
    }

    /**
     * @param  ExhibitionSavingRequest  $request
     * @param  Exhibition  $exhibition
     * @return RedirectResponse
     */
    public function update(ExhibitionSavingRequest $request, Exhibition $exhibition): RedirectResponse
    {
        $exhibition->fill($this->handleAttributes($request));
        $exhibition->makeTranslation(['title', 'description', 'body'])->save();

        if ($request->hasFile('cover')) {
            $exhibition->clearMediaCollection('cover');
            $exhibition->addMediaFromRequest('cover')
                ->usingFileName(makeFileName($request->file('cover')))
                ->toMediaCollection('cover');
        }

        return redirect()->route('admin.exhibitions.edit', $exhibition);
    }

    /**
     * @param  Exhibition  $exhibition
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Exhibition $exhibition): RedirectResponse
    {
        $exhibition->delete();

        return back();
    }

    /**
     * @param  ExhibitionSavingRequest  $request
     * @return array
     */
    private function handleAttributes(ExhibitionSavingRequest $request): array
    {
        $attrs = $request->only('city_id', 'place_id');

        if ($request->filled('starts_at')) {
            $attrs['starts_at'] = Carbon::parse($request->input('starts_at'));
        }

        if ($request->filled('ends_at')) {
            $attrs['ends_at'] = Carbon::parse($request->input('ends_at'));
        }

        if ($request->filled(['starts_at', 'ends_at']) && $attrs['starts_at'] > $attrs['ends_at']) {
            $attrs['starts_at'] = Carbon::parse($request->input('ends_at'));
            $attrs['ends_at'] = Carbon::parse($request->input('starts_at'));
        }
        return $attrs;
    }
}
