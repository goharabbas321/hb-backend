<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Setting\Interfaces\CurrencyRepositoryInterface;
use Modules\Setting\Interfaces\LanguageRepositoryInterface;
use Modules\Setting\Interfaces\SettingRepositoryInterface;

class CachingService
{

    /**
     * @param $key
     * @param callable $callback - Callback function must return a value
     * @param int $time = 3600
     * @return mixed
     */
    public function systemLevelCaching($key, callable $callback, int $time = 3600)
    {
        return Cache::remember($key, $time, $callback);
    }

    /**
     * @param array|string $key
     * @return mixed|string
     */
    public function getSystemSettings(array|string $key = 'system_settings')
    {
        $systemSettings = app(SettingRepositoryInterface::class);

        $settings = $this->systemLevelCaching(config('constants.CACHE.SYSTEM.SETTINGS'), function () use ($systemSettings, $key) {
            return $systemSettings->getSettings($key);
        });

        return $settings;
    }

    public function getSettings(array|string $key)
    {
        $settings = app(SettingRepositoryInterface::class);

        $settings = $this->systemLevelCaching(config('constants.CACHE.SYSTEM.ALL_SETTINGS'), function () use ($settings, $key) {
            return $settings->getSettings($key);
        });

        return $settings;
    }

    public function getJsonSettings($type, $service)
    {
        $allSettings = app(SettingRepositoryInterface::class);

        $settings = $this->systemLevelCaching(config('constants.CACHE.SYSTEM.ALL_SETTINGS'), function () use ($allSettings, $type, $service) {
            return $allSettings->getJsonSettings($type, $service);
        });

        return $settings;
    }

    public function getLanguages()
    {
        $languages = app(LanguageRepositoryInterface::class);
        return $this->systemLevelCaching(config('constants.CACHE.SYSTEM.LANGUAGE'), function () use ($languages) {
            return $languages->all();
        });
    }

    public function getCurrencies()
    {
        $currencies = app(CurrencyRepositoryInterface::class);
        return $this->systemLevelCaching(config('constants.CACHE.SYSTEM.CURRENCY'), function () use ($currencies) {
            return $currencies->all();
        });
    }

    public function getMenu()
    {
        $menu = getMergedMenu();
        return $this->systemLevelCaching(config('constants.CACHE.SYSTEM.MENU'), function () use ($menu) {
            return $menu;
        });
    }

    public function removeSystemCache($key)
    {
        Cache::forget($key);
    }
}
