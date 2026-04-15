<?php

namespace KiriminAja\Laravel;

use Illuminate\Support\ServiceProvider;
use KiriminAja\Base\Config\Cache\Cache;
use KiriminAja\Base\Config\Cache\LaravelCacheStore;
use KiriminAja\Base\Config\KiriminAjaConfig;

class KiriminAjaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->ensureLaravelEnvironment();
        $this->configureCacheStore();
        $this->configureSdk();
    }

    private function ensureLaravelEnvironment(): void
    {
        if (!function_exists('config')) {
            throw new \RuntimeException(
                'KiriminAjaServiceProvider requires a Laravel application. '
                . 'The config() helper is not available. '
                . 'For non-Laravel usage, configure the SDK directly via KiriminAjaConfig.'
            );
        }
    }

    private function configureCacheStore(): void
    {
        $store = config('services.kiriminaja.cache_store', 'laravel');

        if ($store === 'laravel') {
            $prefix = config('services.kiriminaja.cache_prefix', 'kiriminaja:');
            Cache::setStore(new LaravelCacheStore($this->app['cache.store'], $prefix));
        }
    }

    private function configureSdk(): void
    {
        $mode = config('services.kiriminaja.mode');
        if ($mode) {
            KiriminAjaConfig::setMode($mode);
        }

        $apiKey = config('services.kiriminaja.api_key');
        if ($apiKey) {
            KiriminAjaConfig::setApiTokenKey($apiKey);
        }

        $baseUrl = config('services.kiriminaja.base_url');
        if ($baseUrl) {
            KiriminAjaConfig::setBaseUrl($baseUrl);
        }
    }
}
