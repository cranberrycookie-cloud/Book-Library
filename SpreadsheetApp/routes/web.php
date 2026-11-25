<?php

use App\Http\Controllers\BookLibraryController;
use Illuminate\Support\Facades\Route;

// Mendukung akses langsung ke /booklibrary
Route::get('/booklibrary', [BookLibraryController::class, 'index'])->name('booklibrary.root');

Route::prefix('booklibrary')->name('booklibrary.')->group(function () {
    // Halaman Utama (Landing, Galeri, Form Peminjaman, Buku Saya)
    Route::get('/', [BookLibraryController::class, 'index'])->name('index');
    Route::get('/api/search', [BookLibraryController::class, 'searchApi'])->name('api.search');
    Route::post('/api/store', [BookLibraryController::class, 'storeFromApi'])->name('api.store');

    // Login / Logout Akun Gmail Pengunjung
    Route::post('/user/login', [BookLibraryController::class, 'userLogin'])->name('user.login');
    Route::post('/user/logout', [BookLibraryController::class, 'userLogout'])->name('user.logout');

    // Simpan & Kembalikan Peminjaman ke Database
    Route::post('/borrow', [BookLibraryController::class, 'storeBorrow'])->name('borrow.store');
    Route::patch('/borrow/{id}/return', [BookLibraryController::class, 'returnBorrow'])->name('borrow.return');

    // Halaman Terpisah Management System + Auth Pengelola
    Route::get('/manage', [BookLibraryController::class, 'manage'])->name('manage');
    Route::post('/manage/login', [BookLibraryController::class, 'adminLogin'])->name('manage.login');
    Route::post('/manage/logout', [BookLibraryController::class, 'adminLogout'])->name('manage.logout');

    // CRUD Data Peminjaman oleh Admin
    Route::put('/manage/loans/{id}', [BookLibraryController::class, 'updateLoan'])->name('manage.update');
    Route::delete('/manage/loans/{id}', [BookLibraryController::class, 'destroyLoan'])->name('manage.destroy');

    // Export & Import (Menyesuaikan Data Peminjaman Database)
    Route::get('/export', [BookLibraryController::class, 'exportExcel'])->name('export');
    Route::get('/export-pdf', [BookLibraryController::class, 'exportPdf'])->name('exportPdf');
    Route::post('/import', [BookLibraryController::class, 'importExcel'])->name('import');
});