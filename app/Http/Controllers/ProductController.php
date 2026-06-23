<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_if(! $product->is_active, Response::HTTP_NOT_FOUND);

        $product->load(['company', 'links', 'proofs']);

        return Inertia::render('Product', [
            'product' => $product,
        ]);
    }
}
