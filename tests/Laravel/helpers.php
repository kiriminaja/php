<?php

namespace {
    // Laravel config() helper stub for testing outside a full Laravel app.
    if (!function_exists('config')) {
        function config($key = null, $default = null)
        {
            $config = \Illuminate\Container\Container::getInstance()->make('config');
            if (is_null($key)) {
                return $config;
            }
            return $config->get($key, $default);
        }
    }
}
