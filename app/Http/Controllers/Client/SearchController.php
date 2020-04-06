<?php

namespace App\Http\Controllers\Client;

use App\Models\Exhibit;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $products = Product::whereRaw('LOWER(title) LIKE ?', '%' . mb_strtolower($query) . '%')
            ->orWhereRaw('LOWER(description) LIKE ?', '%' . mb_strtolower($query) . '%')->paginate(12);

        return view('client.search.index', [
            'products' => $products,
            'query' => $query
        ]);
    }
}
