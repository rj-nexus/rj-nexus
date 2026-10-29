<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\SeoController;

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
