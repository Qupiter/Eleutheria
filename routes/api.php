<?php

use App\Http\Controllers\Account\AuthController;
use App\Http\Controllers\Account\RoleController;
use App\Http\Controllers\Voting\VoteController;
use App\Models\Account\UserRole;
use Illuminate\Support\Facades\Route;

// Auth routes
// --------------------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// API Routes
// --------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    // API V1 Routes
    // --------------------------------------
    Route::prefix('/v1')->group(function () {
        // Role functionality
        // --------------------------------------
        Route::get('/getMyRoles', [RoleController::class, 'getUserRoles']);
        // Voting functionality
        // --------------------------------------
        Route::group(['middleware' => ['role:'. UserRole::VOTER->value]], function () {
            Route::get('/vote', [VoteController::class, 'vote']);
        });


        // Role protected example routes
        // --------------------------------------
//        Route::group(['middleware' => ['role:voter']], function () {
//            Route::get('/vote', [VoteController::class, 'vote']);
//        });
//        Route::group(['middleware' => ['role:moderator']], function () {
//            Route::get('/vote', [VoteController::class, 'vote']);
//        });
//        Route::group(['middleware' => ['role:manager']], function () {
//            Route::get('/vote', [VoteController::class, 'vote']);
//        });
//        Route::group(['middleware' => ['role:member']], function () {
//            Route::get('/vote', [VoteController::class, 'vote']);
//        });
//        Route::group(['middleware' => ['role:admin']], function () {
//            Route::get('/vote', [VoteController::class, 'vote']);
//        });
    });
});


