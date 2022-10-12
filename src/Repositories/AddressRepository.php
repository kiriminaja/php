<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\ApiBase;
use KiriminAja\Contracts\AddressContract;

class AddressRepository implements AddressContract {

    use ApiBase;

    public function provinces(): array {
        return self::api()->post('api/mitra/province', null);
    }

    public function cities($provinceId): array {
        return self::api()->post('api/mitra/city', ['provinsi_id' => $provinceId]);
    }

    public function districts($cityId): array {
        return self::api()->post('api/mitra/kecamatan', ['kabupaten_id' => $cityId]);
    }

    public function districtsByName($name): array {
        return self::api()->post('api/mitra/v2/get_address_by_name', ['search' => $name]);
    }
}