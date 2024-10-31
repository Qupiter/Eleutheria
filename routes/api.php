<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Version 1 endpoints
    // --------------------------------------
    Route::prefix('/v1')->group(function () {
        // Voter test route
        // --------------------------------------
        Route::group(['middleware' => ['role:voter']], function () {
            Route::get('/vote', [VoteController::class, 'vote']);
        });
    });
});


