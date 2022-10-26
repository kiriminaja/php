<?php

namespace KiriminAja\Unit\Shipping;

use KiriminAja\Repositories\ShippingRepository;
use PHPUnit\Framework\TestCase;

class ShipppingMock extends TestCase
{
    public function shippingMock()
    {
        return \Mockery::mock("overload:".ShippingRepository::class);
    }
}
