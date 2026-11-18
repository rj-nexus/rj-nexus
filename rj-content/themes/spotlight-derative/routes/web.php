<?php

use Illuminate\Support\Facades\Route;
use Spotlight\Http\Controllers\DirectoryController;

// 1. DİL KODU İLƏ OLAN URL-LƏR ÜÇÜN (Məsələn: /en/plugins, /az/plugins)
Route::middleware('web')->prefix('{locale}')->where(['locale' => '[a-zA-Z]{2}'])->group(function () {
    Route::get('/plugins', [DirectoryController::class, 'plugins'])->name('spotlight.plugins.index');
    Route::get('/plugins/{slug}', [DirectoryController::class, 'pluginDetails'])->name('spotlight.plugins.show');
    Route::get('/themes', [DirectoryController::class, 'themes'])->name('spotlight.themes.index');
    Route::get('/themes/{slug}', [DirectoryController::class, 'themeDetails'])->name('spotlight.themes.show');
});

// 2. DİL KODU OLMAYAN URL-LƏR ÜÇÜN (Məsələn: /plugins)
Route::middleware('web')->group(function () {
    Route::get('/plugins', [DirectoryController::class, 'plugins'])->name('spotlight.plugins.index.nolocale');
    Route::get('/plugins/{slug}', [DirectoryController::class, 'pluginDetails'])->name('spotlight.plugins.show.nolocale');
    Route::get('/themes', [DirectoryController::class, 'themes'])->name('spotlight.themes.index.nolocale');
    Route::get('/themes/{slug}', [DirectoryController::class, 'themeDetails'])->name('spotlight.themes.show.nolocale');
});