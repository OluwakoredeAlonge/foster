<?php

use App\Http\Controllers\Api\PublicCourseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Course Catalog (no auth, no gated content)
|--------------------------------------------------------------------------
|
| Consumed by the static Fosterheirs site. Proxies the partner's
| token-gated courses API server-side and strips anything not on the
| public allow-list, see App\Http\Controllers\Api\PublicCourseController.
|
*/
Route::prefix('public')->group(function () {
    Route::get('/courses', [PublicCourseController::class, 'index']);
    Route::get('/courses/{slug}', [PublicCourseController::class, 'show']);
});
