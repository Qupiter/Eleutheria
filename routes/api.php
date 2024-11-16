<?php

use App\Http\Controllers\Account\AuthController;
use App\Http\Controllers\Account\UserRoleController;
use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Voting\VoteController;
use App\Models\Account\UserRole;
use Illuminate\Support\Facades\Route;

// Auth routes
// --------------------------------------
Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// API Routes
// --------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    // API V1 Routes
    // --------------------------------------
    Route::prefix('/v1')->group(function () {
        // Role management
        // --------------------------------------
        Route::prefix('/account')->group(function () {
            Route::get('/roles', [UserRoleController::class, 'index']);
            Route::group([
                'prefix'     => '/roles',
                'middleware' => ['role:' . UserRole::ADMIN->value]
            ], function () {
                Route::get('/{userId?}', [UserRoleController::class, 'index']);
                Route::post('/assign', [UserRoleController::class, 'assign']);
                Route::post('/remove', [UserRoleController::class, 'remove']);
            });
        });
        // User management
        // --------------------------------------
        Route::group([
            'middleware' => ['role:' . UserRole::ADMIN->value]
        ], function () {
            Route::resource('users', UserController::class)->only([
                'index', 'show', 'store', 'update', 'destroy'
            ]);
            Route::delete('users/deactivate/{userId}', [UserController::class, 'discard']);
        });
        // Voting
        // --------------------------------------
        Route::group(['middleware' => ['role:' . UserRole::VOTER->value]], function () {
            Route::get('/vote', [VoteController::class, 'vote']);
        });
    });
});


