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
            return response()->json(['data' => [], 'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 20, 'total' => 0]]);
        }

        $perPage = (int) $request->input('per_page', 20);
        $page = (int) $request->input('page', 1);
        $sort = $request->input('sort', 'rating_desc');
        $minRating = $request->input('min_rating');

        $builder = Product::search($query);

        if ($minRating !== null && is_numeric($minRating)) {
            $minRating = max(0, min(10, (int) $minRating));
            if ($minRating > 0) {
                $builder->where('rating', '>=', $minRating);
            }
        }

        $sortMap = [
            'rating_desc' => ['rating', 'desc'],
            'rating_asc' => ['rating', 'asc'],
            'name_asc' => ['name', 'asc'],
            'name_desc' => ['name', 'desc'],
        ];

        if (isset($sortMap[$sort])) {
            [$column, $direction] = $sortMap[$sort];
            $builder->orderBy($column, $direction);
        }

        $products = $builder->paginate($perPage, 'products', $page);

        $products->getCollection()->load('company');

        SearchLog::create([
            'query' => $query,
        ]);

        return response()->json([
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }
}
