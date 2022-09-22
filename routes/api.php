<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComidaTipicaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    // Route::post('/logout', [AuthController::class, 'logout']);
    // Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::post('/updateUser', [AuthController::class, 'updateUser']);   
    // Route::get('/user-profile', [AuthController::class, 'userProfile']);
    // Route::post('/forgot', [ForgotPasswordController::class, 'forgotPassword']);
    // Route::post('/reset', [ForgotPasswordController::class, 'reset']);
});

Route::middleware('jwt.verify')->prefix('comida-tipica')->group(function () {
    Route::get('/data-init', [ComidaTipicaController::class, 'index']);
    Route::get('/get-category', [ComidaTipicaController::class, 'getCategory']);
    Route::post('/get-meals', [ComidaTipicaController::class, 'getMealsByName']);
    Route::post('/get-meals-category', [ComidaTipicaController::class, 'getMealsByCategory']);
    Route::post('/save-tags', [ComidaTipicaController::class, 'saveTags']);
    Route::get('/get-tags', [ComidaTipicaController::class, 'getTags']);

    // Route::post('/logout', [AuthController::class, 'logout']);
    // Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::post('/updateUser', [AuthController::class, 'updateUser']);   
    // Route::get('/user-profile', [AuthController::class, 'userProfile']);
    // Route::post('/forgot', [ForgotPasswordController::class, 'forgotPassword']);
    // Route::post('/reset', [ForgotPasswordController::class, 'reset']);
});
