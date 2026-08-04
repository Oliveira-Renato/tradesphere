<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StockController::class, 'index'])->name('stock.index');
Route::post('/stock/reduce', [StockController::class, 'reduce'])->name('stock.reduce');