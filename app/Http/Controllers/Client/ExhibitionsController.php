<?php

namespace App\Http\Controllers\Client;

use App\Models\City;
use App\Models\Exhibition;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ExhibitionsController extends Controller
{
    public function index(Request $request): View
    {
        $cities = City::has('exhibitions')->get();

        $years = Exhibition::selectRaw('YEAR(starts_at) as year')->distinct()->get()->pluck('year');

        $exhibitions = $this->handleExhibitions($request);

        return view('client.exhibitions.index', compact('exhibitions', 'cities', 'years'));
    }

    /**
     * @param  Exhibition  $exhibition
     * @return View
     */
    public function show(Exhibition $exhibition): View
    {
        return view('client.exhibitions.show', compact('exhibition'));
    }

    /**
     * @param  Request  $request
     * @return Builder|Collection
     */
    private function handleExhibitions(Request $request)
    {
        if ($request->filled('year')) {
            $year = Carbon::parse($request->input('year'));
        } else {
            $newest = Exhibition::orderByDesc('starts_at')->first();

            if ($newest) {
                $year = Carbon::parse($newest->starts_at);
            } else {
                $year = Carbon::now();
            }
        }

        $exhibitions = Exhibition::orderByDesc('starts_at')
            ->whereDate('starts_at', '>=', $year->startOfYear())
            ->whereDate('starts_at', '<=', $year->endOfYear());

        if ($request->filled('city')) {
            $exhibitions = $exhibitions->where('city_id', $request->input('city'));
        }
        
        return $exhibitions->get();
    }
}
