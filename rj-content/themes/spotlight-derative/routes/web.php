<?php

use Illuminate\Support\Facades\Route;
use Spotlight\Http\Controllers\DirectoryController;

Route::middleware('web')->group(function () {
    Route::get('/{locale}/plugins', [DirectoryController::class, 'plugins'])->name('spotlight.plugins.index');
    Route::get('/{locale}/plugins/{slug}', [DirectoryController::class, 'pluginDetails'])->name('spotlight.plugins.show');

    Route::get('/{locale}/themes', [DirectoryController::class, 'themes'])->name('spotlight.themes.index');
    Route::get('/{locale}/themes/{slug}', [DirectoryController::class, 'themeDetails'])->name('spotlight.themes.show');

    Route::get('/{locale}/docs', [DirectoryController::class, 'docs'])->name('spotlight.docs.index');
    Route::get('/{locale}/docs/{slug}', [DirectoryController::class, 'docs'])->name('spotlight.docs.show');
});