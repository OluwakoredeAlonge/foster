<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\ExternalCourseController;
use App\Http\Controllers\Admin\LandingPageSettingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteResourceController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;
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
    Route::post('/{slug}/import', [ExternalCourseController::class, 'import'])->name('import');
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

Route::prefix('books')->name('admin.books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/create', [BookController::class, 'create'])->name('create');
    Route::post('/', [BookController::class, 'store'])->name('store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy');
    Route::post('/{book}/toggle', [BookController::class, 'toggle'])->name('toggle');
});

Route::prefix('resources')->name('admin.site-resources.')->group(function () {
    Route::get('/', [SiteResourceController::class, 'index'])->name('index');
    Route::get('/create', [SiteResourceController::class, 'create'])->name('create');
    Route::post('/', [SiteResourceController::class, 'store'])->name('store');
    Route::get('/{siteResource}/edit', [SiteResourceController::class, 'edit'])->name('edit');
    Route::put('/{siteResource}', [SiteResourceController::class, 'update'])->name('update');
    Route::delete('/{siteResource}', [SiteResourceController::class, 'destroy'])->name('destroy');
    Route::post('/{siteResource}/toggle', [SiteResourceController::class, 'toggle'])->name('toggle');
});

Route::prefix('contact-settings')->name('admin.contact-settings.')->group(function () {
    Route::get('/', [ContactSettingController::class, 'edit'])->name('edit');
    Route::put('/', [ContactSettingController::class, 'update'])->name('update');
});

Route::prefix('landing-page')->name('admin.landing-page.')->group(function () {
    Route::get('/', [LandingPageSettingController::class, 'edit'])->name('edit');
    Route::put('/', [LandingPageSettingController::class, 'update'])->name('update');
});

Route::prefix('testimonials')->name('admin.testimonials.')->group(function () {
    Route::get('/', [TestimonialController::class, 'index'])->name('index');
    Route::get('/create', [TestimonialController::class, 'create'])->name('create');
    Route::post('/', [TestimonialController::class, 'store'])->name('store');
    Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('edit');
    Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('update');
    Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('destroy');
    Route::post('/{testimonial}/toggle', [TestimonialController::class, 'toggle'])->name('toggle');
});
