<?php

namespace KiriminAja\Base\Config;

use KiriminAja\Base\Config\Cache\_CacheApiKey;
use KiriminAja\Base\Config\Cache\_CacheMode;
use KiriminAja\Base\Config\Cache\_ModeApiKey;

class KiriminAjaConfig {

    /**
     * Getter mode api key only for this class
     *
     * @return _ModeApiKey
     */
    private static function modeApiKey(): _ModeApiKey {
        return new _ModeApiKey;
    }

    /**
     * Setter API token key
     *
     * @param $apiTokenKey
     * @return void
     * @throws \Exception
     */
    public static function setApiTokenKey($apiTokenKey): void
    {
        self::modeApiKey()->apiKey()->setKey($apiTokenKey);
    }

    /**
     * Setter mode
     *
     * @param $mode
     * @return KiriminAjaConfig
     * @throws \Exception
     */
    public static function setMode($mode): KiriminAjaConfig {
        self::modeApiKey()->mode()->setMode($mode);
        return new static();
    }

    /**
     * Getter mode
     *
     * @return _CacheMode
     */
    public static function mode(): _CacheMode {
        return self::modeApiKey()->mode();
    }

    /**
     * Getter API key
     *
     * @return _CacheApiKey
     */
    public static function apiKey(): _CacheApiKey {
        return self::modeApiKey()->apiKey();
    }
}
