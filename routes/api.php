<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Core\Presentation\Api\PegawaiApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pegawai', [PegawaiApiController::class, 'index']);
});
