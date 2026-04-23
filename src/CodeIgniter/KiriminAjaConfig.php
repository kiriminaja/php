<?php

namespace KiriminAja\CodeIgniter;

/**
 * Plain PHP config class for CodeIgniter 4 integration.
 *
 * Users can either:
 *   1. Subclass this in app/Config/KiriminAja.php (extends \CodeIgniter\Config\BaseConfig)
 *      and override the public properties / read from env('kiriminaja.*').
 *   2. Instantiate it directly and pass to KiriminAjaBootstrap::boot().
 *
 * The class is intentionally framework-free so it can be unit-tested
 * without pulling in codeigniter4/framework.
 */
class KiriminAjaConfig
{
    /**
     * 'staging' or 'production'
     */
    public string $mode = 'staging';

    /**
     * Your KiriminAja API key.
     */
    public string $apiKey = '';

    /**
     * Optional override for the API base URL.
     */
    public ?string $baseUrl = null;

    /**
     * Cache backend: 'codeigniter' (uses CI4 cache service) or 'file' (default file store).
     */
    public string $cacheStore = 'codeigniter';

    /**
     * Prefix applied to every cache key (codeigniter store only).
     */
    public string $cachePrefix = 'kiriminaja:';
}
