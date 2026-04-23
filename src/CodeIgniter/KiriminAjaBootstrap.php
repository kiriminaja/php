<?php

namespace KiriminAja\CodeIgniter;

use KiriminAja\Base\Config\Cache\Cache;
use KiriminAja\Base\Config\Cache\CodeIgniterCacheStore;
use KiriminAja\Base\Config\KiriminAjaConfig as SdkConfig;

/**
 * One-shot bootstrap helper for CodeIgniter 4.
 *
 * Wire it up from app/Config/Events.php (recommended):
 *
 *   use KiriminAja\CodeIgniter\KiriminAjaBootstrap;
 *   use Config\Services;
 *
 *   Events::on('pre_system', function () {
 *       KiriminAjaBootstrap::boot(config('KiriminAja'), Services::cache());
 *   });
 */
class KiriminAjaBootstrap
{
    /**
     * Apply the SDK configuration and wire up the cache store.
     *
     * @param object|array $config Either a KiriminAjaConfig (or subclass /
     *                             CodeIgniter\Config\BaseConfig with the
     *                             same public properties) or an associative
     *                             array.
     * @param object|null  $cache  CodeIgniter\Cache\CacheInterface instance
     *                             (typically Services::cache()). May be null
     *                             when cache_store is 'file'.
     */
    public static function boot(object|array $config, ?object $cache = null): void
    {
        $resolved = self::normalize($config);

        if ($resolved['cacheStore'] === 'codeigniter') {
            if ($cache === null) {
                throw new \InvalidArgumentException(
                    'KiriminAjaBootstrap::boot() requires a CodeIgniter cache '
                    . "instance when cache_store is 'codeigniter'. Pass "
                    . '\\Config\\Services::cache() as the second argument.'
                );
            }
            Cache::setStore(new CodeIgniterCacheStore($cache, $resolved['cachePrefix']));
        }

        if ($resolved['mode']) {
            SdkConfig::setMode($resolved['mode']);
        }

        if ($resolved['apiKey'] !== '') {
            SdkConfig::setApiTokenKey($resolved['apiKey']);
        }

        if (!empty($resolved['baseUrl'])) {
            SdkConfig::setBaseUrl($resolved['baseUrl']);
        }
    }

    /**
     * @param object|array $config
     * @return array{mode: string, apiKey: string, baseUrl: ?string, cacheStore: string, cachePrefix: string}
     */
    private static function normalize(object|array $config): array
    {
        if (is_array($config)) {
            return [
                'mode'        => (string) ($config['mode'] ?? 'staging'),
                'apiKey'      => (string) ($config['api_key'] ?? $config['apiKey'] ?? ''),
                'baseUrl'     => $config['base_url'] ?? $config['baseUrl'] ?? null,
                'cacheStore'  => (string) ($config['cache_store'] ?? $config['cacheStore'] ?? 'codeigniter'),
                'cachePrefix' => (string) ($config['cache_prefix'] ?? $config['cachePrefix'] ?? 'kiriminaja:'),
            ];
        }

        return [
            'mode'        => (string) ($config->mode ?? 'staging'),
            'apiKey'      => (string) ($config->apiKey ?? ''),
            'baseUrl'     => $config->baseUrl ?? null,
            'cacheStore'  => (string) ($config->cacheStore ?? 'codeigniter'),
            'cachePrefix' => (string) ($config->cachePrefix ?? 'kiriminaja:'),
        ];
    }
}
