<?php

namespace KiriminAja\Services\Config;

use KiriminAja\Base\Config\Cache\Cache;
use KiriminAja\Base\Config\KiriminAjaConfig;
use PHPUnit\Framework\TestCase;

class CacheDirectoryTest extends TestCase
{
    public function testCacheDirectoryCanBeChanged(): void
    {
        $customDir = sys_get_temp_dir() . '/kiriminaja-phpunit-custom-cache';
        KiriminAjaConfig::setCacheDirectory($customDir);

        $resolved = Cache::getCacheDirectory();
        self::assertTrue(str_starts_with($resolved, rtrim($customDir, DIRECTORY_SEPARATOR)));

        Cache::setCache('unit-test-key', 'unit-test-value');
        self::assertSame('unit-test-value', Cache::getCache('unit-test-key'));
    }
}
