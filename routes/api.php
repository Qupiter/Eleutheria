<?php

use App\Http\Controllers\PartyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('parties')->group(function () {

    // List all parties (Read)
    Route::get('/', [PartyController::class, 'index'])->name('api.parties.index');

//    // Show a single party by ID (Read)
//    Route::get('/{id}', [PartyController::class, 'show'])->name('api.parties.show');
//
//    // Create a new party (Create)
//    Route::post('/', [PartyController::class, 'store'])->name('api.parties.store');
//
//    // Update an existing party (Update)
//    Route::put('/{id}', [PartyController::class, 'update'])->name('api.parties.update');
//
//    // Delete a party (Delete)
//    Route::delete('/{id}', [PartyController::class, 'destroy'])->name('api.parties.destroy');
});
