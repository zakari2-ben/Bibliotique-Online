<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookApiController;

Route::apiResource('books', BookApiController::class);

// Route::prefix('api')->group(function () {
//     Route::apiResource('books', BookApiController::class);
// });