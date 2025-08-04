<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpimetricController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HitungkpiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KpiRecordController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProfileController;


// Route untuk auth
Route::middleware('guest')->group(function () {
    Route::get('/', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
});

Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout.post');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'role:admin|karyawan', 'permission:dashboard-view'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['role:admin|direksi'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:users-view'); //middleware untuk memberikan permission ke role yang didaftarkan di seeder
    Route::post('/user/store-multiple', [UserController::class, 'storeMultiple'])->middleware('permission:users-view')->name('user.storeMultiple');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:users-view');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update')->middleware('permission:users-view');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:users-view');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
});

Route::middleware(['role:admin|karyawan'])->group(function () {
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
// ROute untuk laporan karyawan dan admin
Route::middleware(['role:karyawan'])->group(function () {
    Route::get('/laporan', [HitungkpiController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/download', [HitungkpiController::class, 'download'])->name('laporan.download');
});
Route::middleware(['role:admin|direksi'])->group(function () {
    Route::get('/laporan/admin', [App\Http\Controllers\HitungkpiController::class, 'laporanAdmin'])->name('laporan.admin');
    Route::get('/laporan/admin/download', [App\Http\Controllers\HitungkpiController::class, 'downloadLaporanAdmin'])->name('laporan.admin.download');
    Route::get('/laporan/admin/show/{id}', [App\Http\Controllers\HitungkpiController::class, 'showLaporanAdmin'])->name('laporan.admin.show');
    Route::get('/laporan/admin/download-detail/{id}', [HitungkpiController::class, 'downloadLaporanDetail'])->name('laporan.admin.download.detail');
});

// Route kpirecords
Route::middleware(['auth', 'role:admin|direksi'])->group(function () {
    Route::get('/kpirecords', [\App\Http\Controllers\KpiRecordController::class, 'index'])
        ->name('kpirecords.index');
    Route::delete('/kpirecords/{id}', [\App\Http\Controllers\KpiRecordController::class, 'destroy'])
        ->name('kpirecords.destroy');
});


// Route FAQ
Route::get('/panduan', [FaqController::class, 'index'])->name('faq.index');
Route::get('/panduan/download/{id}', [FaqController::class, 'download'])->name('faq.download');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/panduan/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('/panduan', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/panduan/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit'); // ✅ GET untuk edit
    Route::put('/panduan/{id}', [FaqController::class, 'update'])->name('faq.update');  // ✅ PUT untuk update
    Route::delete('/panduan/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
});
//route untuk profile
Route::middleware(['auth', 'role:admin|karyawan|direksi'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


// route untuk kelola jabatan
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/jobpositions', [App\Http\Controllers\JobPositionController::class, 'index'])->name('jobpositions.index');
    Route::get('/jobpositions/create', [App\Http\Controllers\JobPositionController::class, 'create'])->name('jobpositions.create');
    Route::post('/jobpositions', [App\Http\Controllers\JobPositionController::class, 'store'])->name('jobpositions.store');
    Route::get('/jobpositions/{id}/edit', [App\Http\Controllers\JobPositionController::class, 'edit'])->name('jobpositions.edit');
    Route::put('/jobpositions/{id}', [App\Http\Controllers\JobPositionController::class, 'update'])->name('jobpositions.update');
    Route::delete('/jobpositions/{id}', [App\Http\Controllers\JobPositionController::class, 'destroy'])->name('jobpositions.destroy');
});

// Route untuk AI
Route::middleware(['auth'])->group(function () {
    Route::get('/chatbot', function () {
        return view('pages.AI.chatbot');
    })->name('chatbot.index');

    Route::post('/chatbot/send', [ChatbotController::class, 'send'])->name('chatbot.send');
});
