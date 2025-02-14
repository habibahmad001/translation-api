<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

// Grouping routes that require authentication
Route::middleware('auth:api')->group(function () {
    Route::get('/translations', [TranslationController::class, 'index']);
    Route::post('/translations', [TranslationController::class, 'store']);
    Route::put('/translations/{translation}', [TranslationController::class, 'update']);
    Route::delete('/translations/{translation}', [TranslationController::class, 'destroy']);
    Route::get('/translations/export', [TranslationController::class, 'export']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login',[UserController::class,'userLogin']);

Route::get('profile-details',[UserController::class,'userDetails']);
