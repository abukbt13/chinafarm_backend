<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CropReturnsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FarmProjectController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\PlantingSuggestionController;
use App\Http\Controllers\ProjectReturnController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/farming-projects', [FarmProjectController::class, 'store']);
    Route::get('/farming-projects', [FarmProjectController::class, 'show']);
    Route::get('/farming-projects/count', [FarmProjectController::class, 'countFarmingProjects']);
    Route::get('/farming-projects/{id}', [FarmProjectController::class, 'GetFarmingSeasonById']);


    Route::post('/milestone/{id}', [MilestoneController::class, 'create']);
    Route::post('/milestone/update/{id}', [MilestoneController::class, 'update']);
    Route::post('/milestone/delete/{id}', [MilestoneController::class, 'DeleteMilestone']);
    Route::get('/milestone/show/{id}', [MilestoneController::class, 'show']);


    Route::post('/expenses/{season_id}', [ExpenseController::class, 'storeExpense']);
    Route::get('/expenses/{season_id}', [ExpenseController::class, 'ShowExpense']);
    Route::post('/expenses/update/{season_id}/{expense_id}', [ExpenseController::class, 'editExpense']);
    Route::delete('/expenses/delete/{season_id}/{expense_id}', [ExpenseController::class, 'deleteExpense']);

    Route::post('/project_returns/{season_id}', [ProjectReturnController::class, 'storeProjectReturns']);
    Route::get('/project_returns/{season_id}', [ProjectReturnController::class, 'ShowProjectReturns']);
    Route::post('/project_returns/update/{season_id}/{expense_id}', [ProjectReturnController::class, 'EditProjectReturns']);
    Route::delete('/project_returns/delete/{season_id}/{expense_id}', [ProjectReturnController::class, 'DeleteProjectReturns']);


    Route::get('/planting-suggestions', [PlantingSuggestionController::class, 'index']);
    Route::post('/planting-suggestions', [PlantingSuggestionController::class, 'store']);


    Route::post('/create-blogs', [BlogController::class, 'storeBlogs']);
    Route::get('/show-blogs', [BlogController::class, 'ShowBlogs']);
    Route::get('/show-blog/{hashid}', [BlogController::class, 'ShowBlog']);
    Route::post('/update-blogs', [BlogController::class, 'UpdateBlogs']);
    Route::post('/destroy-blogs', [BlogController::class, 'DestroyBlog']);

    Route::get('/roles-permissions', [RolePermissionController::class, 'index']);
    Route::post('/roles/{roleId}/permissions', [RolePermissionController::class, 'assignPermissions']);


    Route::get('/profile', fn (Request $request) => $request->user());

});
