<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\Traits\ApiBase;
use KiriminAja\Contracts\CourierContract;

class CourierRepository implements CourierContract
{
    use ApiBase;

    /**
     * @return array
     */
    public function list(): array
    {
        return self::api()->post('api/mitra/couriers', null);
    }

    /**
     * @return array
     */
    public function group(): array
    {
        return self::api()->post('api/mitra/couriers_group', null);
    }

    /**
     * @param string $courierCode
     * @return array
     */
    public function detail(string $courierCode): array
    {
        return self::api()->post('api/mitra/courier_services', ['courier_code' => $courierCode]);
    }
}
