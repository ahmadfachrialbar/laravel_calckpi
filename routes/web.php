<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpimetricController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

// route untuk halaman user

Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
Route::get('/user/show{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

// route untuk halaman kpi metrics
Route::get('/kpiMetrics', [App\Http\Controllers\KpimetricController::class, 'index'])->name('kpimetrics.index');
Route::get('/kpiMetrics/create', [App\Http\Controllers\KpimetricController::class, 'create'])->name('kpimetrics.create');
Route::post('/kpiMetrics/store', [App\Http\Controllers\KpimetricController::class, 'store'])->name('kpimetrics.store');
Route::get('/kpiMetrics/edit/{id}', [App\Http\Controllers\KpimetricController::class, 'edit'])->name('kpimetrics.edit');
Route::put('/kpiMetrics/update/{id}', [App\Http\Controllers\KpimetricController::class, 'update'])->name('kpimetrics.update');
Route::delete('/kpiMetrics/delete/{id}', [App\Http\Controllers\KpimetricController::class, 'destroy'])->name('kpimetrics.destroy');    
// route untuk halaman kpi records


