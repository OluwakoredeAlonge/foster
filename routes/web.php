<?php

use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CourseCatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Full, paginated listing of pulled courses. Distinct from /courses,
// which is the imported heirs commerce storefront for courses hosted
// locally on this app.
Route::get('/course-catalog', [CourseCatalogController::class, 'index'])->name('course-catalog');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{post:slug}/comments', [BlogCommentController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('blog.comments.store');

// The old localStorage-only course admin prototype is retired now that
// /admin/courses (routes/admin-courses.php) is a real, database-backed
// course management backend imported from heirs.
Route::redirect('/admin', '/admin/courses')->name('admin');

// Breeze's auth controllers redirect to route('dashboard') after
// login/register/verify; keep that name working.
Route::redirect('/dashboard', '/admin/courses')->name('dashboard');

// The page itself renders inside the admin dashboard shell (see
// profile/edit.blade.php), so it's gated the same way the rest of the
// admin area is — a logged-in student has no use for it and shouldn't
// see the admin sidebar it's wrapped in.
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
