<?php

namespace KiriminAja\Base\Config\Cache;

class Cache {

    private static $prefixCache = "KiriminAja--ApIlkhphpv7t096y--";

    public function __construct() {
        $cached = fopen(self::$cachedFile, 'w');
        fwrite($cached, ob_get_contents());
        fclose($cached);
    }

    /**
     * Getter cache
     *
     * @param $key
     * @return mixed|null
     */
    public static function getCache($key) {
        if (isset($_SESSION[self::$prefixCache.$key])) {
            return $_SESSION[self::$prefixCache.$key];
        } else {
            return null;
        }
    }

    /**
     * Setter cache
     *
     * @param $key
     * @param $value
     * @return void
     */
    public static function setCache($key, $value) {
        $_SESSION[self::$prefixCache.$key] = $value;
    }
}