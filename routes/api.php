<?php

use Dedoc\Scramble\Scramble;
use Illuminate\Support\Facades\Route;

Scramble::registerUiRoute('');
Scramble::registerJsonSpecificationRoute('json');

Route::middleware('throttle:api')->prefix('v1')->group(function () {
});
