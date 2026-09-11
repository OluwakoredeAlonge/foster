<?php

namespace App\Providers;

use App\Models\ContactSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // site-header/site-footer are @included on every public-facing page
        // (homepage, course catalog, course storefront), and the homepage's
        // own contact section repeats the same data — composing them
        // directly means none of those controllers need to remember to
        // pass $contactSettings themselves.
        View::composer(
            ['partials.site-header', 'partials.site-footer', 'welcome'],
            fn ($view) => $view->with('contactSettings', ContactSetting::current())
        );
    }
}
