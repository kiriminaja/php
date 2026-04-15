<?php

namespace KiriminAja\Base\Config\Cache;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use KiriminAja\Contracts\CacheStoreContract;

class LaravelCacheStore implements CacheStoreContract
{
    private CacheRepository $cache;
    private string $prefix;

    public function __construct(CacheRepository $cache, string $prefix = 'kiriminaja:')
    {
        $this->cache = $cache;
        $this->prefix = $prefix;
    }

    public function get(string $key): mixed
    {
        return $this->cache->get($this->prefix . $key);
    }

    public function put(string $key, mixed $value, int $expiry): bool
    {
        return $this->cache->put($this->prefix . $key, $value, $expiry);
    }

    public function remove(string $key): bool
    {
        return $this->cache->forget($this->prefix . $key);
    }
}
