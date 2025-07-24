<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FarmingSeasonController;
use App\Http\Controllers\API\MilestoneController;
use App\Http\Controllers\CropReturnsController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/farming-progress', [FarmingSeasonController::class, 'store']);
    Route::get('/farming-progress', [FarmingSeasonController::class, 'show']);

    Route::get('/farming-progress/{id}', [FarmingSeasonController::class, 'GetFarmingSeasonById']);


    Route::post('/milestone/{id}', [MilestoneController::class, 'create']);
    Route::get('/milestone/show/{id}', [MilestoneController::class, 'show']);
    Route::get('/milestone/delete/{id}', [MilestoneController::class, 'DeleteMilestone']);
    Route::post('/milestone/update/{id}', [MilestoneController::class, 'UpdateMilestone']);


    Route::post('/expenses/{season_id}', [ExpenseController::class, 'storeExpenses']);
    Route::get('/expenses/{season_id}', [ExpenseController::class, 'ShowExpenses']);
    Route::post('/expenses/update/{season_id}/{expense_id}', [ExpenseController::class, 'editExpenses']);
    Route::delete('/expenses/delete/{season_id}/{expense_id}', [ExpenseController::class, 'deleteExpenses']);

    Route::post('/crop_returns/{season_id}', [CropReturnsController::class, 'storeCropReturns']);
    Route::get('/crop_returns/{season_id}', [CropReturnsController::class, 'ShowCropReturnss']);
    Route::post('/crop_returns/update/{season_id}/{expense_id}', [CropReturnsController::class, 'EditCropReturnss']);
    Route::delete('/crop_returns/delete/{season_id}/{expense_id}', [CropReturnsController::class, 'DeleteCropReturnss']);

    Route::get('/profile', fn (Request $request) => $request->user());

});
