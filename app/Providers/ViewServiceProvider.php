<?php

namespace App\Providers;

use App\Services\CachingService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $cache = app(CachingService::class);

        $systemSettings = $cache->getSystemSettings();
        $languages = $cache->getLanguages();
        $currencies = $cache->getCurrencies();
        $menu = $cache->getMenu();

        // Share vertical menu data to all the views
        $this->app->make('view')->share('menuData', [$menu]);

        // Share the settings variable with all views
        View::share(config('constants.CACHE.SYSTEM.SETTINGS'), $systemSettings);

        // Store settings in the container for controller access
        app()->singleton(config('constants.CACHE.SYSTEM.SETTINGS'), function () use ($systemSettings) {
            return $systemSettings;
        });

        // Share the languages variable with all views
        View::share(config('constants.CACHE.SYSTEM.LANGUAGE'), $languages);

        // Store languages in the container for controller access
        app()->singleton(config('constants.CACHE.SYSTEM.LANGUAGE'), function () use ($languages) {
            return $languages;
        });

        // Share the currencies variable with all views
        View::share(config('constants.CACHE.SYSTEM.CURRENCY'), $currencies);

        // Store currencies in the container for controller access
        app()->singleton(config('constants.CACHE.SYSTEM.CURRENCY'), function () use ($currencies) {
            return $currencies;
        });
    }
}
