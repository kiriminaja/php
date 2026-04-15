<?php

namespace KiriminAja\Base\Config\Cache;

use KiriminAja\Contracts\CacheStoreContract;

class Cache
{
    /**
     * Pluggable cache store. When null, falls back to default FileCacheStore.
     */
    private static ?CacheStoreContract $store = null;

    /**
     * Allow disabling cache entirely (useful for read-only environments).
     */
    private static bool $enabled = true;

    /**
     * Set a custom cache store implementation.
     *
     * Example (Laravel): Cache::setStore(new LaravelCacheStore(app('cache.store')));
     */
    public static function setStore(CacheStoreContract $store): void
    {
        self::$store = $store;
        self::$enabled = true;
    }

    /**
     * Get the current cache store instance.
     */
    public static function getStore(): CacheStoreContract
    {
        return self::resolveStore();
    }

    /**
     * Configure where cache files are stored (file-based store only).
     * Useful for environments where /tmp is not writable.
     *
     * Example: Cache::setCacheDirectory(__DIR__ . '/storage/cache');
     */
    public static function setCacheDirectory(string $directory): void
    {
        $store = self::resolveStore();
        if ($store instanceof FileCacheStore) {
            $store->setCacheDirectory($directory);
        }
        self::$enabled = true;
    }

    /**
     * Returns the cache directory being used (file-based store only).
     */
    public static function getCacheDirectory(): string
    {
        $store = self::resolveStore();
        if ($store instanceof FileCacheStore) {
            return $store->getCacheDirectory();
        }
        return '';
    }

    /**
     * Enable/disable caching.
     */
    public static function setEnabled(bool $enabled): void
    {
        self::$enabled = $enabled;
    }

    /**
     * Getter cache
     *
     * @param $key
     * @return mixed|null
     */
    public static function getCache($key): mixed
    {
        return @self::get($key) ?? null;
    }

    /**
     * Setter cache
     *
     * @param $key
     * @param $value
     * @param int $expiry
     * @return void
     */
    public static function setCache($key, $value, int $expiry = 604800): void
    {
        self::put($key, $value, $expiry);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key): mixed
    {
        if (!self::$enabled) {
            return null;
        }
        return self::resolveStore()->get($key);
    }

    /**
     * @param string $key
     * @param string $value
     * @param integer $expiry
     * @return bool
     */
    public static function put(string $key, string $value, int $expiry): bool
    {
        if (!self::$enabled) {
            return false;
        }
        return self::resolveStore()->put($key, $value, $expiry);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function remove(string $key): bool
    {
        if (!self::$enabled) {
            return false;
        }
        return self::resolveStore()->remove($key);
    }

    /**
     * Resolve the cache store, defaulting to FileCacheStore.
     */
    private static function resolveStore(): CacheStoreContract
    {
        if (self::$store === null) {
            self::$store = new FileCacheStore();
        }
        return self::$store;
    }

    /**
     * Reset the store (useful for testing).
     */
    public static function resetStore(): void
    {
        self::$store = null;
        self::$enabled = true;
    }
}
