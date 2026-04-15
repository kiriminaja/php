<?php

namespace KiriminAja\Laravel;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use KiriminAja\Base\Config\Cache\Cache;
use KiriminAja\Base\Config\Cache\LaravelCacheStore;
use Mockery;
use PHPUnit\Framework\TestCase;

class LaravelCacheStoreTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        Cache::resetStore();
        parent::tearDown();
    }

    public function testPutDelegatesToLaravelCache(): void
    {
        $mock = Mockery::mock(CacheRepository::class);
        $mock->shouldReceive('put')
            ->once()
            ->with('kiriminaja:test-key', 'test-value', 3600)
            ->andReturn(true);

        $store = new LaravelCacheStore($mock);
        $result = $store->put('test-key', 'test-value', 3600);

        $this->assertTrue($result);
    }

    public function testGetDelegatesToLaravelCache(): void
    {
        $mock = Mockery::mock(CacheRepository::class);
        $mock->shouldReceive('get')
            ->once()
            ->with('kiriminaja:my-key')
            ->andReturn('cached-value');

        $store = new LaravelCacheStore($mock);
        $result = $store->get('my-key');

        $this->assertEquals('cached-value', $result);
    }

    public function testGetReturnsNullForMissingKey(): void
    {
        $mock = Mockery::mock(CacheRepository::class);
        $mock->shouldReceive('get')
            ->once()
            ->with('kiriminaja:missing')
            ->andReturn(null);

        $store = new LaravelCacheStore($mock);
        $result = $store->get('missing');

        $this->assertNull($result);
    }

    public function testRemoveDelegatesToLaravelCacheForget(): void
    {
        $mock = Mockery::mock(CacheRepository::class);
        $mock->shouldReceive('forget')
            ->once()
            ->with('kiriminaja:old-key')
            ->andReturn(true);

        $store = new LaravelCacheStore($mock);
        $result = $store->remove('old-key');

        $this->assertTrue($result);
    }

    public function testCustomPrefixIsUsed(): void
    {
        $mock = Mockery::mock(CacheRepository::class);
        $mock->shouldReceive('put')
            ->once()
            ->with('custom:test-key', 'value', 60)
            ->andReturn(true);
        $mock->shouldReceive('get')
            ->once()
            ->with('custom:test-key')
            ->andReturn('value');

        $store = new LaravelCacheStore($mock, 'custom:');

        $this->assertTrue($store->put('test-key', 'value', 60));
        $this->assertEquals('value', $store->get('test-key'));
    }

    public function testCacheClassDelegatesToLaravelStore(): void
    {
        $mock = Mockery::mock(CacheRepository::class);
        $mock->shouldReceive('put')
            ->once()
            ->with('kiriminaja:some-key', 'hello!', 300)
            ->andReturn(true);
        $mock->shouldReceive('get')
            ->once()
            ->with('kiriminaja:some-key')
            ->andReturn('hello!');

        $store = new LaravelCacheStore($mock);
        Cache::setStore($store);

        Cache::setCache('some-key', 'hello!', 300);
        $result = Cache::getCache('some-key');

        $this->assertEquals('hello!', $result);
    }

    public function testCacheDisabledDoesNotHitLaravelStore(): void
    {
        $mock = Mockery::mock(CacheRepository::class);
        $mock->shouldNotReceive('get');
        $mock->shouldNotReceive('put');

        $store = new LaravelCacheStore($mock);
        Cache::setStore($store);
        Cache::setEnabled(false);

        $this->assertNull(Cache::get('anything'));
        $this->assertFalse(Cache::put('anything', 'value', 60));
    }
}
