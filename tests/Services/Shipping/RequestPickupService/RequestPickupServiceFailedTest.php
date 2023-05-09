<?php

namespace KiriminAja\Services\Shipping\RequestPickupService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Models\RequestPickupData;
use KiriminAja\Services\Shipping\RequestPickupService;
use Mockery;
use PHPUnit\Framework\TestCase;

class RequestPickupServiceFailedTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }


    public function testFailedService()
    {
        $this->tearDown();
        $this->expectException(\TypeError::class);

        (new RequestPickupService("WO"))->call();
    }


    public function testIsEmpty(){
        $this->tearDown();
        $this->expectException(\TypeError::class);

        $pickup_object = new RequestPickupData();
        $pickup_object->address = NULL;

        (new RequestPickupService($pickup_object))->call();
    }
}
