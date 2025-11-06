<?php

use App\Http\Controllers\web\AccountController;
use App\Http\Controllers\web\CategoryController;
use App\Http\Controllers\web\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('loadapp');
});

Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.create');
Route::delete('/accounts/{id}', [AccountController::class, 'delete'])->name('accounts.delete');
Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');

Route::post('/transactions', [TransactionController::class, 'create'])->name('transactions.create');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

Route::get('/categories/{type}', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/test', function () {
    return view('test');
});
