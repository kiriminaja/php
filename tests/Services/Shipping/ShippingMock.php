<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Repositories\ShippingRepository;
use PHPUnit\Framework\TestCase;

class ShippingMock extends TestCase
{
    protected \Mockery\MockInterface|\Mockery\LegacyMockInterface|null $mockery = null;
    public function shippingMock()
    {
        $this->mockery = \Mockery::mock("overload:".ShippingRepository::class);
        return $this->mockery;
    }
}
