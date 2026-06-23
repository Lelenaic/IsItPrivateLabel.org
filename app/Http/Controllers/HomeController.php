<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $suggestedProducts = Product::query()
            ->select('name')
            ->where('is_active', true)
            ->whereNotNull('name')
            ->inRandomOrder()
            ->limit(3)
            ->pluck('name');

        return Inertia::render('Home', [
            'suggestedProducts' => $suggestedProducts,
        ]);
    }
}
