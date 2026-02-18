<?php

namespace KiriminAja\Services\Config;

use KiriminAja\Base\Config\Cache\_CacheApiKey;
use KiriminAja\Base\Config\KiriminAjaConfig;
use PHPUnit\Framework\TestCase;

class CacheApiKeyTest extends TestCase {

    public function testCacheApiKey() {
        KiriminAjaConfig::setCacheDirectory(sys_get_temp_dir() . '/kiriminaja-phpunit-cache');
        $cache = new _CacheApiKey;
        $cache->setKey("2323");
//        echo "\nAPI-Key : ".$cache->getKey();
        self::assertTrue(is_string($cache->getKey()));
    }

}
