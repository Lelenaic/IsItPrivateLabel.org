<?php

use App\Http\Controllers\Api\ProductController;
use Dedoc\Scramble\Scramble;
use Illuminate\Support\Facades\Route;

Scramble::registerUiRoute('');
Scramble::registerJsonSpecificationRoute('json');

Route::middleware('throttle:api')->prefix('v1')->group(function () {
    Route::get('/search', [ProductController::class, 'search']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
});
