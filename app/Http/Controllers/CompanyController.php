<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function show(Company $company)
    {
        $company->load('products');
        $averageRating = $company->averageRating();

        return Inertia::render('Company', [
            'company' => $company,
            'averageRating' => $averageRating,
        ]);
    }
}
