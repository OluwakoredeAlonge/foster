<?php

use App\Http\Controllers\Courses\CheckoutController;
use App\Http\Controllers\Courses\CourseMaterialController;
use App\Http\Controllers\Courses\CourseProgressController;
use App\Http\Controllers\Courses\CourseRegistrationController;
use App\Http\Controllers\Courses\CourseReviewController;
use App\Http\Controllers\Courses\StorefrontController;
use App\Http\Controllers\Courses\StudentAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('courses')->name('courses.')->group(function () {
    Route::get('/', [StorefrontController::class, 'index'])->name('index');

    Route::middleware('guest')->group(function () {
        Route::get('/register', [StudentAuthController::class, 'showRegister'])->name('register');
        Route::get('/login', [StudentAuthController::class, 'showLogin'])->name('login');

        // Rate-limited: unlike the staff LoginRequest, these have no other
        // brute-force protection, so this is the only thing standing
        // between a guest and unlimited password guesses / mass signups.
        Route::middleware('throttle:6,1')->group(function () {
            Route::post('/register', [StudentAuthController::class, 'register'])->name('register.store');
            Route::post('/login', [StudentAuthController::class, 'login'])->name('login.store');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
        Route::get('/my-courses', [CheckoutController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [CheckoutController::class, 'confirmation'])->name('orders.show');
        Route::post('/orders/{order}/mark-paid', [CheckoutController::class, 'markPaid'])->name('orders.markPaid');
    });

    Route::get('/{course:slug}', [StorefrontController::class, 'show'])->name('show');

    Route::middleware('auth')->group(function () {
        Route::post('/{course:slug}/buy', [CheckoutController::class, 'store'])->name('buy');
        Route::post('/{course:slug}/reviews', [CourseReviewController::class, 'store'])->name('reviews.store');
        Route::get('/{course:slug}/materials/{material}/download', [CourseMaterialController::class, 'download'])->name('materials.download');
        Route::post('/{course:slug}/progress', [CourseProgressController::class, 'toggle'])->name('progress.toggle');
        Route::get('/{course:slug}/registration', [CourseRegistrationController::class, 'create'])->name('registration.create');
        Route::post('/{course:slug}/registration', [CourseRegistrationController::class, 'store'])->name('registration.store');
    });
});
