<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TradeController;

Auth::routes();
Route::get('/', fn() => redirect('home'));

// Rutas protegidas con middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Grupo para rutas de trades
    Route::prefix('trades')->name('trades.')->group(function () {
        Route::get('/', [TradeController::class, 'index'])->name('index');
        Route::get('/{trade}/edit', [TradeController::class, 'edit'])->name('edit');
        Route::put('/{trade}', [TradeController::class, 'update'])->name('update');        
        Route::delete('/{id}/destroy', [TradeController::class, 'destroy'])->name('destroy');
        Route::post('/', [TradeController::class, 'store'])->name('store');
    });
});