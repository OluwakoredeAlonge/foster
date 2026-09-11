<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// The old localStorage-only course admin prototype is retired now that
// /admin/courses (routes/admin-courses.php) is a real, database-backed
// course management backend imported from heirs.
Route::redirect('/admin', '/admin/courses')->name('admin');

// Breeze's auth controllers redirect to route('dashboard') after
// login/register/verify; keep that name working.
Route::redirect('/dashboard', '/admin/courses')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
