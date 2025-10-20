<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('loadapp');
});

Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');

Route::post('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
Route::delete('/accounts/{id}', [AccountController::class, 'delete'])->name('accounts.delete');
Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
Route::get('/test', function () {
    return view('test');
});
