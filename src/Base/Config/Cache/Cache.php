<?php

namespace KiriminAja\Base\Config\Cache;

class Cache
{

    private static string $prefixCache = "KiriminAja--ApIlkhphpv7t096y--";

    public function __construct()
    {
        $cached = fopen(self::$prefixCache, 'w');
        fwrite($cached, ob_get_contents());
        fclose($cached);
    }

    /**
     * Getter cache
     *
     * @param $key
     * @return mixed|null
     */
    public static function getCache($key)
    {
        return $_SESSION[self::$prefixCache . $key] ?? null;
    }

    /**
     * Setter cache
     *
     * @param $key
     * @param $value
     * @return void
     */
    public static function setCache($key, $value)
    {
        $_SESSION[self::$prefixCache . $key] = $value;
    }
}
