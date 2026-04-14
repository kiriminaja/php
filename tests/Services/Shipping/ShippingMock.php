<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Repositories\ShippingRepository;

class ShippingMock
{
    protected \Mockery\MockInterface|\Mockery\LegacyMockInterface|null $mockery = null;
    public function shippingMock()
    {
        $this->mockery = \Mockery::mock("overload:".ShippingRepository::class);
        return $this->mockery;
    }
}
