<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OurMissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WhatIsPrivateLabelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product:slug}/all-proofs', [ProductController::class, 'allProofs'])->name('products.allProofs');
Route::get('/companies/{company:slug}', [CompanyController::class, 'show'])->name('companies.show');
Route::get('/what-is-private-label', [WhatIsPrivateLabelController::class, 'index'])->name('what-is-private-label');
Route::get('/our-mission', [OurMissionController::class, 'index'])->name('our-mission');

Route::get('/language/{language:code}', [LanguageController::class, 'switch'])->name('language.switch');
