<?php

namespace KiriminAja\Base\Config\Cache;

class _CacheMode {
    private static $key = '---KiriminAja-Cached-Mode-Key---';

    /**
     * allowed mode
     *
     * @return array
     */
    private static function allowedMode(): array {
        return [Mode::Production, Mode::Staging];
    }

    /**
     * Setter mode
     *
     * @param Mode::string $mode
     * @return void
     */
    public function setMode($mode) {
        if (!in_array($mode, self::allowedMode())) throw new \Exception("Mode not allowed, allowed mode ".json_encode(self::allowedMode()).", your mode $mode");
        Cache::setCache(self::$key, $mode);
    }

    /**
     * Getter key
     *
     * @return mixed|null
     */
    public function getMode() {
        return Cache::getCache(self::$key) ?? Mode::Staging;
    }

    /**
     * Getter is Staging mode
     *
     * @return bool
     */
    public function isStaging(): bool {
        return strtolower($this->getMode()) == "staging";
    }

    /**
     * Getter is production mode
     *
     * @return bool
     */
    public function isProduction(): bool {
        return strtolower($this->getMode()) == "production";
    }
}

