<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SearchLog;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::search($query)
            ->take(20)
            ->get()
            ->load('company');

        SearchLog::create([
            'query' => $query,
        ]);

        return response()->json($products);
    }
}
