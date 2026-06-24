<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchProductsRequest;
use App\Http\Resources\Api\ProductDetailResource;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('Products', description: 'Search and retrieve private label products', weight: 0)]
class ProductController extends Controller
{
    /**
     * Search for products by name, serial number, or company name.
     *
     * Returns a paginated list of active products matching the query.
     * Requires at least 2 characters to perform a search.
     */
    public function search(SearchProductsRequest $request): AnonymousResourceCollection
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return ProductResource::collection(
                Product::query()->paginate((int) $request->input('per_page', 20))
            );
        }

        $perPage = (int) $request->input('per_page', 20);
        $page = (int) $request->input('page', 1);

        $products = Product::search($query)
            ->where('is_active', true)
            ->paginate($perPage, 'products', $page);

        $products->getCollection()->load(['company', 'translations.language']);

        return ProductResource::collection($products);
    }

    /**
     * Get a single product by its slug or ID.
     *
     * Returns the full product details including company, translations, links, pricings, and proofs.
     */
    #[PathParameter('product', description: 'Product slug or numeric ID.', example: 'organic-whole-milk')]
    public function show(string $product): ProductDetailResource
    {
        $product = is_numeric($product)
            ? Product::findOrFail($product)
            : Product::where('slug', $product)->firstOrFail();

        abort_if(! $product->is_active, 404);

        $product->load([
            'company',
            'links',
            'proofs.translations.language',
            'proofs.visibleInLanguages',
            'translations.language',
            'pricings',
        ]);

        return new ProductDetailResource($product);
    }
}
