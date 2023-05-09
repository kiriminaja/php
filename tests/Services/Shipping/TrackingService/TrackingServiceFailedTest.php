<?php

namespace KiriminAja\Services\Shipping\TrackingService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Services\Shipping\ShippingMock;
use KiriminAja\Services\Shipping\TrackingService;
use Mockery;
use PHPUnit\Framework\TestCase;

class TrackingServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFailedService()
    {
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'tracking' => [
                    false,
                    [
                        'status'      => false,
                        'text'        => 'Failed to get tracking data'
                    ]
                ]
            ]);

        $order_id = 'OID-MOCK123';
        $result = (new TrackingService($order_id))->call();
        self::assertFalse($result->status);
    }

    public function testIsEmpty(){
        $this->expectException(\TypeError::class);
        $order_id = null;
        (new TrackingService($order_id))->call();
    }

    public function testIsInteger(){

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'tracking' => [
                    false,
                    [
                        'status'      => false,
                        'text'        => "Params order_id must be an string",
                        'data'        => null
                    ]
                ]
            ]);

        $order_id = 12332423;
        $result = (new TrackingService($order_id))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params order_id must be an string", $result->message);
        self::assertEquals(null, $result->data);
    }
}
