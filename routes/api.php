<?php

use App\Http\Controllers\APIArticleController;

Route::controller(APIArticleController::class)->group(function() {
   Route::get('/articles', 'articles');
   Route::get('/sources', 'sources');
});