<?php

namespace KiriminAja\Unit\Shipping\RequestPickupService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Models\RequestPickupData;
use KiriminAja\Services\Shipping\RequestPickupService;
use KiriminAja\Unit\Shipping\ShippingMock;
use PHPUnit\Framework\TestCase;
use Mockery;

class RequestPickupServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }


    public function testFailedService()
    {
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'requestPickup' => [
                    false,
                    [
                        'status' => false,
                        'text'   => 'Failed to fetch shipping pickup data'
                    ]
                ]
            ]);

        $pickup_object = new RequestPickupData();
        $result = (new RequestPickupService($pickup_object))->call();
        self::assertFalse($result->status);
    }


    public function testIsEmpty(){

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'requestPickup' => [
                    false,
                    [
                        'status' => false,
                        'text'   => "Required params can't be blank"
                    ]
                ]
            ]);

        $pickup_object = new RequestPickupData();
        $pickup_object->address = NULL;
        $pickup_object->phone = NULL;
        $pickup_object->name = NULL;
        $pickup_object->kecamatan_id = NULL;
        $pickup_object->schedule = NULL;
        $pickup_object->zipcode = 16610;
        $pickup_object->platform_name = 'mitra';
        $pickup_object->packages = [];

        $result = (new RequestPickupService($pickup_object))->call();

        self::assertFalse($result->status);
        self::assertEquals("Required params can't be blank", $result->message);
    }
}
