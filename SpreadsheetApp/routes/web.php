<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookLibraryController;

// HALAMAN UTAMA
Route::get('/', [BookLibraryController::class, 'index'])
    ->name('home');

// BOOK LIBRARY
Route::get('/booklibrary', [BookLibraryController::class, 'index'])
    ->name('booklibrary.index');

// MANAGE
Route::get('/booklibrary/manage', [BookLibraryController::class, 'manage'])
    ->name('booklibrary.manage');
    
// CRUD
// Tambah / simpan buku
Route::post('/booklibrary', [BookLibraryController::class, 'store'])
    ->name('booklibrary.store');

// Edit / update buku
Route::put('/booklibrary/{id}', [BookLibraryController::class, 'update'])
    ->name('booklibrary.update');

// Hapus buku
Route::delete('/booklibrary/{id}', [BookLibraryController::class, 'destroy'])
    ->name('booklibrary.destroy');

// EXPORT
// Export Excel
Route::get('/booklibrary/export', [BookLibraryController::class, 'export'])
    ->name('booklibrary.export');
// Export PDF
Route::get('/booklibrary/export-pdf', [BookLibraryController::class, 'exportPdf'])
    ->name('booklibrary.exportPdf');

// IMPORT EXCEL
Route::post('/booklibrary/import', [BookLibraryController::class, 'import'])
    ->name('booklibrary.import');