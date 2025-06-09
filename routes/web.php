<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GameController;
use App\Http\Controllers\AdminController;

Route::get('/', [GameController::class, 'index'])->name('game.index');
Route::get('/words', [GameController::class, 'getWords'])->name('game.words');
Route::post('/leaderboard', [GameController::class, 'storeScore'])->name('game.storeScore');
Route::get('/leaderboard', [GameController::class, 'leaderboard'])->name('game.leaderboard');

Route::prefix('admin')->group(function () {
    Route::get('/words', [AdminController::class, 'index'])->name('admin.words.index');
    Route::post('/words', [AdminController::class, 'store'])->name('admin.words.store');
    Route::delete('/words/{id}', [AdminController::class, 'destroy'])->name('admin.words.destroy');
});
