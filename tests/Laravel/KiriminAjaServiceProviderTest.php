<?php

namespace KiriminAja\Laravel;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use KiriminAja\Base\Config\Cache\Cache;
use KiriminAja\Base\Config\Cache\LaravelCacheStore;
use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Base\Config\KiriminAjaConfig;
use Mockery;
use PHPUnit\Framework\TestCase;

class KiriminAjaServiceProviderTest extends TestCase
{
    private Container $app;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::resetStore();
        $this->app = new Container();
        Container::setInstance($this->app);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        Cache::resetStore();
        Container::setInstance(null);
        parent::tearDown();
    }

    private function setConfig(array $kiriminajaConfig): void
    {
        $config = new ConfigRepository([
            'services' => [
                'kiriminaja' => $kiriminajaConfig,
            ],
        ]);
        $this->app->instance('config', $config);
    }

    private function createTrackingCacheMock(): CacheRepository
    {
        $store = [];
        $cacheMock = Mockery::mock(CacheRepository::class);
        $cacheMock->shouldReceive('put')
            ->andReturnUsing(function ($key, $value, $ttl) use (&$store) {
                $store[$key] = $value;
                return true;
            });
        $cacheMock->shouldReceive('get')
            ->andReturnUsing(function ($key) use (&$store) {
                return $store[$key] ?? null;
            });
        $cacheMock->shouldReceive('forget')
            ->andReturnUsing(function ($key) use (&$store) {
                unset($store[$key]);
                return true;
            });
        return $cacheMock;
    }

    public function testBootConfiguresSdkModeAndApiKey(): void
    {
        $cacheMock = $this->createTrackingCacheMock();

        $this->app->instance('cache.store', $cacheMock);
        $this->setConfig([
            'mode' => Mode::Production,
            'api_key' => 'test-api-key-12345',
            'base_url' => null,
            'cache_store' => 'laravel',
            'cache_prefix' => 'kiriminaja:',
        ]);

        $provider = new KiriminAjaServiceProvider($this->app);
        $provider->register();
        $provider->boot();

        $this->assertInstanceOf(LaravelCacheStore::class, Cache::getStore());
        $this->assertEquals(Mode::Production, KiriminAjaConfig::mode()->getMode());
        $this->assertEquals('test-api-key-12345', KiriminAjaConfig::apiKey()->getKey());
    }

    public function testBootWithFileCacheStoreDoesNotSetLaravelStore(): void
    {
        $this->app->instance('cache.store', Mockery::mock(CacheRepository::class));
        $this->setConfig([
            'mode' => Mode::Staging,
            'api_key' => 'file-test-key',
            'base_url' => null,
            'cache_store' => 'file',
            'cache_prefix' => 'kiriminaja:',
        ]);

        $provider = new KiriminAjaServiceProvider($this->app);
        $provider->register();
        $provider->boot();

        $this->assertNotInstanceOf(LaravelCacheStore::class, Cache::getStore());
    }

    public function testBootConfiguresCustomBaseUrl(): void
    {
        $cacheMock = $this->createTrackingCacheMock();

        $this->app->instance('cache.store', $cacheMock);
        $this->setConfig([
            'mode' => Mode::Staging,
            'api_key' => 'url-test-key',
            'base_url' => 'https://custom.example.com',
            'cache_store' => 'laravel',
            'cache_prefix' => 'test:',
        ]);

        $provider = new KiriminAjaServiceProvider($this->app);
        $provider->register();
        $provider->boot();

        $this->assertEquals('https://custom.example.com', KiriminAjaConfig::baseUrl()->getBaseUrl());
    }

    public function testBootWithCustomPrefix(): void
    {
        $storedKeys = [];
        $cacheMock = Mockery::mock(CacheRepository::class);
        $cacheMock->shouldReceive('put')
            ->andReturnUsing(function ($key, ...$args) use (&$storedKeys) {
                $storedKeys[] = $key;
                return true;
            });
        $cacheMock->shouldReceive('get')->andReturn(null);

        $this->app->instance('cache.store', $cacheMock);
        $this->setConfig([
            'mode' => Mode::Staging,
            'api_key' => 'prefix-test-key',
            'base_url' => null,
            'cache_store' => 'laravel',
            'cache_prefix' => 'myapp:',
        ]);

        $provider = new KiriminAjaServiceProvider($this->app);
        $provider->register();
        $provider->boot();

        $this->assertInstanceOf(LaravelCacheStore::class, Cache::getStore());
        foreach ($storedKeys as $key) {
            $this->assertStringStartsWith('myapp:', $key);
        }
    }

    public function testBootSkipsEmptyApiKey(): void
    {
        $cacheMock = $this->createTrackingCacheMock();

        $this->app->instance('cache.store', $cacheMock);
        $this->setConfig([
            'mode' => Mode::Staging,
            'api_key' => '',
            'base_url' => null,
            'cache_store' => 'laravel',
            'cache_prefix' => 'kiriminaja:',
        ]);

        $provider = new KiriminAjaServiceProvider($this->app);
        $provider->register();

        // Should not throw - empty api_key is skipped
        $provider->boot();
        $this->assertTrue(true);
    }

    public function testBootSkipsNullBaseUrl(): void
    {
        $cacheMock = $this->createTrackingCacheMock();

        $this->app->instance('cache.store', $cacheMock);
        $this->setConfig([
            'mode' => Mode::Staging,
            'api_key' => 'some-key',
            'base_url' => null,
            'cache_store' => 'laravel',
            'cache_prefix' => 'kiriminaja:',
        ]);

        $provider = new KiriminAjaServiceProvider($this->app);
        $provider->register();
        $provider->boot();

        // No exception means null base_url was properly skipped
        $this->assertTrue(true);
    }
}
