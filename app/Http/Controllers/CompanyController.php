<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function show(Company $company)
    {
        $company->load('products.translations.language');
        $averageRating = $company->averageRating();

        $locale = app()->getLocale();

        $company->setRelation(
            'products',
            $company->products->map(function ($product) use ($locale) {
                $product->translated_name = $product->getTranslatedName($locale);
                $product->translated_description = $product->getTranslatedDescription($locale);
                $product->translated_image_path = $product->getTranslatedImagePath($locale);
                $product->translation_available = $product->isAvailableInLocale($locale);

                return $product;
            }),
        );

        return Inertia::render('Company', [
            'company' => $company,
            'averageRating' => $averageRating,
        ]);
    }
}
