<?php

use App\Http\Controllers\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('links', LinkController::class);
    Route::get('links/{link}/qrcode', [LinkController::class, 'downloadQrCode'])->name('links.qrcode');
});
