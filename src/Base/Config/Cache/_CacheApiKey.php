<?php

namespace KiriminAja\Base\Config\Cache;

class _CacheApiKey
{
    private static string $key = '---KiriminAja-Cached-Api-Key---';

    /**
     * Setter key
     *
     * @param $apiKey
     * @return void
     * @throws \Exception
     */
    public function setKey($apiKey)
    {
        if (!is_string($apiKey)) throw new \Exception("api key must be string");
        Cache::setCache(self::$key, $apiKey);
    }

    /**
     * Getter key
     *
     * @return mixed|null
     */
    public function getKey()
    {
        return Cache::getCache(self::$key);
    }

}
