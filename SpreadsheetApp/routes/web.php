<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NovelCollectionController;

Route::get('/', [NovelCollectionController::class, 'index']);

Route::get('/novelcollection', [NovelCollectionController::class, 'index'])
    ->name('novelcollection.index');

Route::get('/novelcollection/export', [NovelCollectionController::class, 'export'])
    ->name('novelcollection.export');

Route::get('/novelcollection/export-pdf', [NovelCollectionController::class, 'exportPdf'])
    ->name('novelcollection.exportPdf');

Route::post('/novelcollection/import', [NovelCollectionController::class, 'import'])
    ->name('novelcollection.import');