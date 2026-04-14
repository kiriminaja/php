<?php

namespace KiriminAja\Services\Config;

use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Base\Config\KiriminAjaConfig;
use PHPUnit\Framework\TestCase;

class BaseUrlTest extends TestCase
{
    protected function setUp(): void
    {
        KiriminAjaConfig::setCacheDirectory(sys_get_temp_dir() . '/kiriminaja-phpunit-cache');
        // Clear any previously set custom base URL
        KiriminAjaConfig::baseUrl()->clearBaseUrl();
    }

    public function testCustomBaseUrlCanBeSet(): void
    {
        $customUrl = 'https://proxy.example.com';
        KiriminAjaConfig::setBaseUrl($customUrl);

        $baseUrl = KiriminAjaConfig::baseUrl()->getBaseUrl();
        self::assertSame($customUrl, $baseUrl);
    }

    public function testCustomBaseUrlStripsTrailingSlash(): void
    {
        KiriminAjaConfig::setBaseUrl('https://proxy.example.com/');

        $baseUrl = KiriminAjaConfig::baseUrl()->getBaseUrl();
        self::assertSame('https://proxy.example.com', $baseUrl);
    }

    public function testCustomBaseUrlCanBeCleared(): void
    {
        KiriminAjaConfig::setBaseUrl('https://proxy.example.com');
        KiriminAjaConfig::baseUrl()->clearBaseUrl();

        $baseUrl = KiriminAjaConfig::baseUrl()->getBaseUrl();
        self::assertNull($baseUrl);
    }

    public function testBaseUrlWithChainedConfig(): void
    {
        $customUrl = 'https://proxy.example.com';
        KiriminAjaConfig::setMode(Mode::Production)
            ::setBaseUrl($customUrl)
            ::setApiTokenKey('test-key');

        $baseUrl = KiriminAjaConfig::baseUrl()->getBaseUrl();
        self::assertSame($customUrl, $baseUrl);
    }

    public function testEmptyBaseUrlThrowsException(): void
    {
        $this->expectException(\Exception::class);
        KiriminAjaConfig::setBaseUrl('');
    }

    public function testDefaultBaseUrlIsNullWhenNotSet(): void
    {
        $baseUrl = KiriminAjaConfig::baseUrl()->getBaseUrl();
        self::assertNull($baseUrl);
    }
}
