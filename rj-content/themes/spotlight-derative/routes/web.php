<?php

use Illuminate\Support\Facades\Route;
use Spotlight\Http\Controllers\DirectoryController;

Route::middleware('web')->group(function () {
    Route::get('/plugins', [DirectoryController::class, 'plugins'])->name('spotlight.plugins.index');
    Route::get('/plugins/{slug}', [DirectoryController::class, 'pluginDetails'])->name('spotlight.plugins.show');
    Route::get('/themes', [DirectoryController::class, 'themes'])->name('spotlight.themes.index');
    Route::get('/themes/{slug}', [DirectoryController::class, 'themeDetails'])->name('spotlight.themes.show');
});