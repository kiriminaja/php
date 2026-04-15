<?php

namespace KiriminAja\Services\Courier;

use KiriminAja\Repositories\CourierRepository;

class CourierMock
{
    public function courierMock()
    {
        return \Mockery::mock("overload:" . CourierRepository::class);
    }
}
