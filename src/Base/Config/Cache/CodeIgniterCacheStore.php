<?php

namespace KiriminAja\Base\Config\Cache;

use KiriminAja\Contracts\CacheStoreContract;

/**
 * CodeIgniter 4 cache adapter.
 *
 * Wraps any object that quacks like CodeIgniter\Cache\CacheInterface
 * (save / get / delete). The dependency is intentionally duck-typed so
 * we do not have to require codeigniter4/framework at runtime.
 *
 * Example:
 *   use Config\Services;
 *   Cache::setStore(new CodeIgniterCacheStore(Services::cache()));
 */
class CodeIgniterCacheStore implements CacheStoreContract
{
    /** @var object */
    private $cache;
    private string $prefix;

    public function __construct(object $cache, string $prefix = 'kiriminaja:')
    {
        if (!method_exists($cache, 'save') || !method_exists($cache, 'get') || !method_exists($cache, 'delete')) {
            throw new \InvalidArgumentException(
                'CodeIgniterCacheStore expects an object exposing save(), get() and delete() '
                . '(e.g. CodeIgniter\Cache\CacheInterface).'
            );
        }
        $this->cache = $cache;
        $this->prefix = $prefix;
    }

    public function get(string $key): mixed
    {
        $value = $this->cache->get($this->prefix . $key);
        return $value === false ? null : $value;
    }

    public function put(string $key, mixed $value, int $expiry): bool
    {
        return (bool) $this->cache->save($this->prefix . $key, $value, $expiry);
    }

    public function remove(string $key): bool
    {
        return (bool) $this->cache->delete($this->prefix . $key);
    }
}
