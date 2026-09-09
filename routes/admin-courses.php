<?php

use App\Http\Controllers\Courses\Admin\CourseCategoryController;
use App\Http\Controllers\Courses\Admin\CourseOrderController;
use App\Http\Controllers\Courses\Admin\CourseRegistrationController;
use App\Http\Controllers\Courses\Admin\CourseReviewController;
use App\Http\Controllers\Courses\Admin\PaymentSettingsController;
use App\Http\Controllers\Courses\Admin\StudentController;
use App\Http\Controllers\Courses\AdminCourseController;
use Illuminate\Support\Facades\Route;

// IMPORTANT: these static-path routes (/payment-settings, /orders, etc.)
// must be registered BEFORE the Course Management group below — that
// group's PUT/DELETE /{course} wildcard routes would otherwise greedily
// match "payment-settings" or "orders" as a course slug (Laravel matches
// routes in registration order) and 404 via route-model-binding.
Route::prefix('courses')->name('admin.courses.')->group(function () {
    Route::get('/payment-settings', [PaymentSettingsController::class, 'edit'])->name('payment-settings.edit');
    Route::put('/payment-settings', [PaymentSettingsController::class, 'update'])->name('payment-settings.update');

    Route::get('/orders', [CourseOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/confirm', [CourseOrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/reject', [CourseOrderController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{order}/revoke', [CourseOrderController::class, 'revoke'])->name('orders.revoke');
    Route::post('/orders/{order}/reinstate', [CourseOrderController::class, 'reinstate'])->name('orders.reinstate');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::post('/students/{student}/send-certificate', [StudentController::class, 'sendCertificate'])->name('students.send-certificate');

    Route::get('/reviews', [CourseReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [CourseReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/registrations', [CourseRegistrationController::class, 'index'])->name('registrations.index');

    Route::get('/categories', [CourseCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CourseCategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CourseCategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::prefix('courses')->name('admin.courses.')->controller(AdminCourseController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{course}/edit', 'edit')->name('edit');
    Route::put('/{course}', 'update')->name('update');
    Route::delete('/{course}', 'destroy')->name('destroy');
    Route::delete('/{course}/materials/{material}', 'destroyMaterial')->name('materials.destroy');
    Route::delete('/{course}/course-image', 'destroyCourseImage')->name('course-image.destroy');
    Route::post('/{course}/duplicate', 'duplicate')->name('duplicate');
});
