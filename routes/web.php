<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::controller(ArticleController::class)->group(function() {
    Route::get('/', 'index')->name('index');
    Route::post('/fetch-news', 'fetch_news')->name('fetch_news');
});

Route::get('logs', [LogViewerController::class, 'index']);

Route::get('/test', function() {
    \App\Traits\PusherNews::triggerEventNews();
    return 'done';
});