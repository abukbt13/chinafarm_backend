<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FarmingSeasonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/farming-seasons', [FarmingSeasonController::class, 'store']);
    Route::get('/profile', fn (Request $request) => $request->user());
});
