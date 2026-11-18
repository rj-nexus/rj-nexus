<?php

use Illuminate\Support\Facades\Route;
use Spotlight\Http\Controllers\DirectoryController;

$registerRoutes = function () {
    Route::get('/plugins', [DirectoryController::class, 'plugins'])->name('spotlight.plugins.index');
    Route::get('/plugins/{slug}', [DirectoryController::class, 'pluginDetails'])->name('spotlight.plugins.show');
    Route::get('/themes', [DirectoryController::class, 'themes'])->name('spotlight.themes.index');
    Route::get('/themes/{slug}', [DirectoryController::class, 'themeDetails'])->name('spotlight.themes.show');
};

// 1. Dil kodu OLMAYAN url-lər üçün (məsələn: /plugins)
Route::middleware('web')->group($registerRoutes);

// 2. Dil kodu OLan url-lər üçün (məsələn: /en/plugins, /az/plugins)
Route::middleware('web')->prefix('{locale}')->where(['locale' => '[a-zA-Z]{2}'])->group($registerRoutes);