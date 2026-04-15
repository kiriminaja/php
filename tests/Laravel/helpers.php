<?php

if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        $config = \Illuminate\Container\Container::getInstance()->make('config');
        if ($key === null) {
            return $config;
        }
        return $config->get($key, $default);
    }
}
