<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
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
        // Share the site settings singleton with the front-end layout and partials.
        View::composer(['layouts.site', 'partials.*', 'pages.*'], function ($view) {
            static $settings;

            if ($settings === null) {
                $settings = Schema::hasTable('site_settings')
                    ? SiteSetting::current()
                    : new SiteSetting();
            }

            $view->with('settings', $settings);
        });
    }
}
