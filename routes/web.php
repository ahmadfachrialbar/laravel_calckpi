<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpimetricController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HitungkpiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KpiRecordController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProfileController;


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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('permission:users-view');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
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
    Route::post('/kpimetrics/store', [KpimetricController::class, 'store'])->name('kpimetrics.store');
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

// Route kpirecords

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/kpirecords', [KpiRecordController::class, 'index'])->name('kpirecords.index');
    Route::get('/kpirecords/{id}/edit', [KpiRecordController::class, 'edit'])->name('kpirecords.edit');
    Route::put('/kpirecords/{id}', [KpiRecordController::class, 'update'])->name('kpirecords.update');
    Route::delete('/kpirecords/{id}', [KpiRecordController::class, 'destroy'])->name('kpirecords.destroy');
    
});

// Route untuk FAQ
Route::get('/panduan', [FaqController::class, 'index'])->name('faq.index');
Route::get('/panduan/create', [FaqController::class, 'create'])->name('faq.create'); // opsional, untuk admin
Route::post('/panduan', [FaqController::class, 'store'])->name('faq.store');
Route::get('/panduan/download/{id}', [FaqController::class, 'download'])->name('faq.download');

//route untuk profile
Route::middleware(['auth', 'role:admin|karyawan'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

});

Route::middleware(['role:karyawan'])->group(function () {
    Route::get('/laporan', [HitungkpiController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/download', [HitungkpiController::class, 'download'])->name('laporan.download');
});
