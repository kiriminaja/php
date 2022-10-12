<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\ApiBase;
use KiriminAja\Contracts\PreferenceContract;

class PreferenceRepository implements PreferenceContract {

    use ApiBase;

    public function setWhiteListExpedition($services): array {
        if (!is_array($services)) throw new \Exception('service is not array');
        return self::api()->post('api/mitra/v3/set_whitelist_services', ['services' => $services]);
    }

    public function setCallback($url): array {
        return self::api()->post('api/mitra/set_callback', ['url' => $url]);
    }
}