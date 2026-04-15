<?php

namespace KiriminAja\Base\Config\Cache;

use KiriminAja\Contracts\CacheStoreContract;

class FileCacheStore implements CacheStoreContract
{
    private const DEFAULT_CACHE_SUBFOLDER = 'kiriminaja-temp-cache';

    private ?string $cacheDirectory = null;
    private bool $prepared = false;

    public function __construct(?string $cacheDirectory = null)
    {
        if ($cacheDirectory !== null) {
            $this->cacheDirectory = rtrim($cacheDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }
    }

    public function setCacheDirectory(string $directory): void
    {
        $this->cacheDirectory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->prepared = false;
    }

    public function getCacheDirectory(): string
    {
        return $this->resolveCacheDirectory();
    }

    public function get(string $key): mixed
    {
        if (!$this->prepare()) {
            return null;
        }

        $file = $this->cacheKeyConvert($key) . '.cache';
        $contents = $this->loadCacheFile($file);
        if ($contents === false) {
            return null;
        }

        $json_content = json_decode($contents);
        if (!is_object($json_content) || !isset($json_content->expiry) || !isset($json_content->value)) {
            $this->deleteCacheFile($file);
            return null;
        }

        if (time() > $json_content->expiry) {
            $this->deleteCacheFile($file);
            return null;
        }

        return unserialize($json_content->value, ['allowed_classes' => false]);
    }

    public function put(string $key, mixed $value, int $expiry): bool
    {
        if (!$this->prepare()) {
            return false;
        }

        $cacheKey = $key;
        $file = $this->cacheKeyConvert($key) . '.cache';
        $store = json_encode([
            'key' => $cacheKey,
            'expiry' => time() + $expiry,
            'value' => serialize($value),
        ]);

        return $this->saveCacheFile($file, $store);
    }

    public function remove(string $key): bool
    {
        if (!$this->prepare()) {
            return false;
        }

        $file = $this->cacheKeyConvert($key) . '.cache';
        return $this->deleteCacheFile($file);
    }

    private function loadCacheFile(string $file): bool|string
    {
        $file = $this->resolveCacheDirectory() . $file;
        if (file_exists($file)) {
            return file_get_contents($file);
        }
        return false;
    }

    private function saveCacheFile(string $file, string $data): bool
    {
        $file = $this->resolveCacheDirectory() . $file;
        return (!(@file_put_contents($file, $data) === false));
    }

    private function deleteCacheFile(string $file): bool
    {
        $file = $this->resolveCacheDirectory() . $file;
        if (!file_exists($file)) {
            return true;
        }
        return (@unlink($file) !== false);
    }

    private function cacheKeyConvert(string $key): string
    {
        return md5('kajCache_' . $key);
    }

    private function prepare(): bool
    {
        if ($this->prepared) {
            return true;
        }

        $directory = $this->resolveCacheDirectory();

        if (!file_exists($directory)) {
            if (@mkdir($directory, 0777, true) === false) {
                return false;
            }
        }

        if (!is_writable($directory)) {
            return false;
        }

        $this->prepared = true;
        return true;
    }

    private function resolveCacheDirectory(): string
    {
        if ($this->cacheDirectory !== null) {
            return $this->cacheDirectory;
        }

        $temp = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        return $temp . self::DEFAULT_CACHE_SUBFOLDER . DIRECTORY_SEPARATOR;
    }
}
