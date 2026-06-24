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

        $product->load([
            'company',
            'links',
            'proofs.translations.language',
            'proofs.visibleInLanguages',
            'translations.language',
            'pricings',
        ]);

        $locale = app()->getLocale();

        $translation = $product->getTranslationFor($locale);
        $availableInLocale = $product->isAvailableInLocale($locale);

        $proofs = $product->proofs
            ->filter(fn ($proof) => $proof->isVisibleInLocale($locale))
            ->map(fn ($proof) => [
                'id' => $proof->id,
                'type' => $proof->type,
                'content' => $proof->getTranslatedContent($locale),
                'description' => $proof->getTranslatedDescription($locale),
            ])
            ->values()
            ->all();

        return Inertia::render('Product', [
            'product' => $product,
            'translation' => $translation,
            'availableInLocale' => $availableInLocale,
            'proofs' => $proofs,
        ]);
    }

    public function allProofs(Product $product)
    {
        abort_if(! $product->is_active, Response::HTTP_NOT_FOUND);

        $product->load(['proofs.translations.language']);

        $locale = app()->getLocale();

        $proofs = $product->proofs
            ->map(fn ($proof) => [
                'id' => $proof->id,
                'type' => $proof->type,
                'content' => $proof->getTranslatedContent($locale),
                'description' => $proof->getTranslatedDescription($locale),
            ])
            ->values()
            ->all();

        return response()->json(['proofs' => $proofs]);
    }
}
