<?php

namespace KiriminAja\Base\Config\Cache;

class Cache
{
    const TIME_5_MIN = 300;
    const TIME_HALF_HOUR = 1800;
    const TIME_1_HOUR = 3600;
    const TIME_12_HOUR = 43200;
    const TIME_1_DAY = 86400;
    const TIME_1_WEEK = 604800;
    const CACHE_FOLDER = '/tmp/kiriminaja-temp-cache';

    /**
     * @var bool
     */
    private static bool $prepared = false;

    /**
     * Getter cache
     *
     * @param $key
     * @return mixed|null
     */
    public static function getCache($key): mixed
    {
        return @self::get($key) ?? null;
    }

    /**
     * Setter cache
     *
     * @param $key
     * @param $value
     * @return void
     */
    public static function setCache($key, $value): void
    {
        self::put($key, $value, self::TIME_1_WEEK);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key): mixed
    {
        if (self::prepare()) {
            $key = self::cache_key_convert($key);
            $file = $key . '.cache';
            $contents = self::load_cache_file($file);
            if ($contents === false) {
                return null;
            }
            $json_content = json_decode($contents);
            $expiry = $json_content->expiry;
            if (time() > $expiry) {
                self::delete_cache_file($file);
                return null;
            }
            return unserialize($json_content->value);
        }
        return null;
    }

    /**
     * @param string $key
     * @param string $value
     * @param integer $expiry
     * @return bool
     */
    public static function put(string $key, string $value, int $expiry): bool
    {
        if (self::prepare()) {
            $cache_key = $key;
            $key = self::cache_key_convert($key);
            $file = $key . '.cache';
            $expiry = time() + $expiry;
            $serialized = serialize($value);
            $store = array(
                'key' => $cache_key,
                'expiry' => $expiry,
                'value' => $serialized
            );
            $store = json_encode($store);
            return self::save_cache_file($file, $store);
        }
        return false;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function remove(string $key): bool
    {
        if (self::prepare()) {
            $key = self::cache_key_convert($key);
            $file = $key . '.cache';
            return self::delete_cache_file($file);
        }
        return false;
    }

    /**
     * @param string $file
     * @return bool|string
     */
    private static function load_cache_file(string $file): bool|string
    {
        $file = self::CACHE_FOLDER . $file;
        if (file_exists($file)) {
            return file_get_contents($file);
        }
        return false;
    }

    /**
     * @param string $file
     * @param string $data
     * @return bool
     */
    private static function save_cache_file(string $file, string $data): bool
    {
        $file = self::CACHE_FOLDER . $file;
        return (!(file_put_contents($file, $data) === false));
    }

    /**
     * @param string $file
     * @return bool
     */
    private static function delete_cache_file(string $file): bool
    {
        $file = self::CACHE_FOLDER . $file;
        return unlink($file);
    }

    /**
     * @param string $key
     * @return string
     */
    private static function cache_key_convert(string $key): string
    {
        $key = 'kajCache_' . $key;
        return md5($key);
    }

    /**
     * @return bool
     */
    private static function prepare(): bool
    {
        if (self::$prepared) {
            return true;
        }
        self::$prepared = true;
        if (file_exists(self::CACHE_FOLDER) === false) {
            return mkdir(self::CACHE_FOLDER);
        }
        return true;
    }
}
