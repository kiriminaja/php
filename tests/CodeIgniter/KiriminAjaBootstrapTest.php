<?php

namespace KiriminAja\CodeIgniter;

use KiriminAja\Base\Config\Cache\Cache;
use KiriminAja\Base\Config\Cache\CodeIgniterCacheStore;
use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Base\Config\KiriminAjaConfig as SdkConfig;
use PHPUnit\Framework\TestCase;

/**
 * Minimal stand-in for CodeIgniter\Cache\CacheInterface so we don't have
 * to require codeigniter4/framework just for tests.
 */
class FakeCi4Cache
{
    /** @var array<string, mixed> */
    public array $store = [];

    public function save(string $key, mixed $value, int $ttl = 60): bool
    {
        $this->store[$key] = $value;
        return true;
    }

    public function get(string $key): mixed
    {
        return $this->store[$key] ?? false;
    }

    public function delete(string $key): bool
    {
        unset($this->store[$key]);
        return true;
    }
}

class KiriminAjaBootstrapTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::resetStore();
    }

    protected function tearDown(): void
    {
        Cache::resetStore();
        parent::tearDown();
    }

    public function testBootWithConfigObject(): void
    {
        $cache = new FakeCi4Cache();

        $config = new KiriminAjaConfig();
        $config->mode = Mode::Production;
        $config->apiKey = 'ci4-test-key';
        $config->baseUrl = 'https://ci4.example.com';
        $config->cacheStore = 'codeigniter';
        $config->cachePrefix = 'ci4:';

        KiriminAjaBootstrap::boot($config, $cache);

        $this->assertInstanceOf(CodeIgniterCacheStore::class, Cache::getStore());
        $this->assertSame(Mode::Production, SdkConfig::mode()->getMode());
        $this->assertSame('ci4-test-key', SdkConfig::apiKey()->getKey());
        $this->assertSame('https://ci4.example.com', SdkConfig::baseUrl()->getBaseUrl());
    }

    public function testBootWithAssociativeArray(): void
    {
        $cache = new FakeCi4Cache();

        KiriminAjaBootstrap::boot([
            'mode'         => Mode::Staging,
            'api_key'      => 'arr-key',
            'base_url'     => null,
            'cache_store'  => 'codeigniter',
            'cache_prefix' => 'arr:',
        ], $cache);

        $this->assertInstanceOf(CodeIgniterCacheStore::class, Cache::getStore());
        $this->assertSame(Mode::Staging, SdkConfig::mode()->getMode());
        $this->assertSame('arr-key', SdkConfig::apiKey()->getKey());
    }

    public function testBootWithFileStoreSkipsCi4Adapter(): void
    {
        $config = new KiriminAjaConfig();
        $config->mode = Mode::Staging;
        $config->apiKey = 'file-mode-key';
        $config->cacheStore = 'file';

        KiriminAjaBootstrap::boot($config);

        $this->assertNotInstanceOf(CodeIgniterCacheStore::class, Cache::getStore());
    }

    public function testBootRequiresCacheWhenCi4StoreSelected(): void
    {
        $config = new KiriminAjaConfig();
        $config->cacheStore = 'codeigniter';

        $this->expectException(\InvalidArgumentException::class);
        KiriminAjaBootstrap::boot($config, null);
    }

    public function testCacheStoreUsesPrefix(): void
    {
        $cache = new FakeCi4Cache();
        $store = new CodeIgniterCacheStore($cache, 'pfx:');

        $store->put('balance', 1000, 60);
        $this->assertArrayHasKey('pfx:balance', $cache->store);
        $this->assertSame(1000, $store->get('balance'));

        $store->remove('balance');
        $this->assertArrayNotHasKey('pfx:balance', $cache->store);
    }

    public function testCacheStoreReturnsNullWhenMissing(): void
    {
        $cache = new FakeCi4Cache();
        $store = new CodeIgniterCacheStore($cache);

        $this->assertNull($store->get('missing'));
    }

    public function testCacheStoreRejectsObjectWithoutSaveGetDelete(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new CodeIgniterCacheStore(new \stdClass());
    }
}
