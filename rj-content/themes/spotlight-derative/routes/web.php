<?php

use Illuminate\Support\Facades\Route;
use Spotlight\Http\Controllers\DirectoryController;

Route::middleware('web')->group(function () {
    // Dil kodu məcburi olaraq {locale} qəbul edir (məsələn: /en/plugins)
    Route::get('/{locale}/plugins', [DirectoryController::class, 'plugins'])->name('spotlight.plugins.index');
    Route::get('/{locale}/plugins/{slug}', [DirectoryController::class, 'pluginDetails'])->name('spotlight.plugins.show');
    
    Route::get('/{locale}/themes', [DirectoryController::class, 'themes'])->name('spotlight.themes.index');
    Route::get('/{locale}/themes/{slug}', [DirectoryController::class, 'themeDetails'])->name('spotlight.themes.show');
});