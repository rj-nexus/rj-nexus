<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\SeoController;

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])
    ->middleware('throttle:100,1')
    ->name('sitemap');

Route::get('/robots.txt', [SeoController::class, 'robots'])
    ->middleware('throttle:100,1')
    ->name('robots');