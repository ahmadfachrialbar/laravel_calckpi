<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpimetricController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HitungkpiController;


// Route untuk auth
Route::get('/', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout.post');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'registerView'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');


Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'role:admin|karyawan', 'permission:dashboard-view'])->name('dashboard');




// Route untuk halaman yang bisa di akses admin
Route::middleware(['role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('permission:users-view');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/store-multiple', [UserController::class, 'storeMultiple'])->name('user.storeMultiple');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});


Route::middleware(['role:admin|karyawan'])->group(function () {
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/kpimetrics', [KpimetricController::class, 'index'])->name('kpimetrics.index');
    Route::get('/kpimetrics/show/{id}', [KpimetricController::class, 'show'])->name('kpimetrics.show');
    Route::get('/kpimetrics/create', [KpimetricController::class, 'create'])->name('kpimetrics.create');
    Route::post('/kpimetrics/store', [KpimetricController::class, 'store'])->name('kpimetrics.store');
});

// Khusus admin
Route::middleware(['role:admin'])->group(function () {
    Route::get('/kpimetrics/create', [KpimetricController::class, 'create'])->name('kpimetrics.create');
    Route::post('/kpimetrics/store', [KpimetricController::class, 'store'])->name('kpimetrics.store');
    Route::post('/kpimetrics/store-multiple', [KpimetricController::class, 'storeMultiple'])->name('kpimetrics.storeMultiple');
    Route::get('/kpimetrics/edit/{id}', [KpimetricController::class, 'edit'])->name('kpimetrics.edit');
    Route::put('/kpimetrics/update/{id}', [KpimetricController::class, 'update'])->name('kpimetrics.update');
    Route::delete('/kpimetrics/delete/{id}', [KpimetricController::class, 'destroy'])->name('kpimetrics.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/hitungkpi', [HitungKpiController::class, 'index'])
        ->name('hitungkpi.index');
    Route::post('/hitungkpi', [HitungKpiController::class, 'store'])
        ->name('hitungkpi.store');
});

