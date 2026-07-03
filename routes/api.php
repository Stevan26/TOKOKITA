<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukApiController;
use App\Http\Controllers\ApiAuthController;

Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/produk', [ProdukApiController::class, 'index']);
});
