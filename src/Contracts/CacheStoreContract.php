<?php

namespace KiriminAja\Contracts;

interface CacheStoreContract
{
    /**
     * Retrieve a value from the cache.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key): mixed;

    /**
     * Store a value in the cache.
     *
     * @param string $key
     * @param string $value
     * @param int $expiry TTL in seconds
     * @return bool
     */
    public function put(string $key, string $value, int $expiry): bool;

    /**
     * Remove a value from the cache.
     *
     * @param string $key
     * @return bool
     */
    public function remove(string $key): bool;
}
