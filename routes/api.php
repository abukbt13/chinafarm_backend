<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FarmingSeasonController;
use App\Http\Controllers\API\MilestoneController;
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
    Route::get('/farming-seasons', [FarmingSeasonController::class, 'show']);

    Route::get('/farming-season/{id}', [FarmingSeasonController::class, 'GetFarmingSeasonById']);


    Route::post('/milestone', [MilestoneController::class, 'create']);
    Route::get('/milestone/{id}', [MilestoneController::class, 'show']);
    Route::get('/milestone/delete/{id}', [MilestoneController::class, 'DeleteMilestone']);
    Route::post('/milestone/update/{id}', [MilestoneController::class, 'UpdateMilestone']);




    Route::get('/profile', fn (Request $request) => $request->user());

});
