<?php

use App\Http\Controllers\Admin\ExternalCourseController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamMemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site content admin (Fosterheirs' own homepage modules)
|--------------------------------------------------------------------------
|
| Distinct from routes/admin-courses.php (the imported heirs course
| commerce backend) — these control the public marketing site itself:
| which pulled external courses show, and the Services / Our Therapists
| sections on the homepage.
|
*/
Route::prefix('external-courses')->name('admin.external-courses.')->group(function () {
    Route::get('/', [ExternalCourseController::class, 'index'])->name('index');
    Route::post('/{slug}/toggle', [ExternalCourseController::class, 'toggle'])->name('toggle');
});

Route::prefix('services')->name('admin.services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/create', [ServiceController::class, 'create'])->name('create');
    Route::post('/', [ServiceController::class, 'store'])->name('store');
    Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
    Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
    Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
    Route::post('/{service}/toggle', [ServiceController::class, 'toggle'])->name('toggle');
});

Route::prefix('team-members')->name('admin.team-members.')->group(function () {
    Route::get('/', [TeamMemberController::class, 'index'])->name('index');
    Route::get('/create', [TeamMemberController::class, 'create'])->name('create');
    Route::post('/', [TeamMemberController::class, 'store'])->name('store');
    Route::get('/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('edit');
    Route::put('/{teamMember}', [TeamMemberController::class, 'update'])->name('update');
    Route::delete('/{teamMember}', [TeamMemberController::class, 'destroy'])->name('destroy');
    Route::post('/{teamMember}/toggle', [TeamMemberController::class, 'toggle'])->name('toggle');
});
