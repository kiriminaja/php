<?php

namespace KiriminAja\Base\Config\Cache;

class _CacheBaseUrl
{
    private static string $key = '---KiriminAja-Cached-Base-Url---';

    /**
     * Setter base url
     *
     * @param string $baseUrl
     * @return void
     * @throws \Exception
     */
    public function setBaseUrl(string $baseUrl): void
    {
        if (!is_string($baseUrl) || empty($baseUrl)) {
            throw new \Exception("base url must be a non-empty string");
        }
        Cache::setCache(self::$key, rtrim($baseUrl, '/'));
    }

    /**
     * Getter base url
     *
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        return Cache::getCache(self::$key);
    }

    /**
     * Clear base url
     *
     * @return void
     */
    public function clearBaseUrl(): void
    {
        Cache::remove(self::$key);
    }
}
