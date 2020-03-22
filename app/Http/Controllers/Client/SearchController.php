<?php

namespace App\Http\Controllers\Client;

use App\Models\Exhibit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $exhibits = Exhibit::whereRaw('LOWER(title) LIKE ?', '%'.mb_strtolower($query).'%')->orWhereRaw('LOWER(props) LIKE ?', '%'.mb_strtolower($query).'%')->paginate(12);

        return view('client.search.index', [
            'exhibits' => $exhibits,
            'query' => $query
        ]);
    }
}
