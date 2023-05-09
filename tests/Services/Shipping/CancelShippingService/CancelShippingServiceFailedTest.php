<?php

namespace KiriminAja\Services\Shipping\CancelShippingService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Services\Shipping\CancelShippingService;
use KiriminAja\Services\Shipping\ShippingMock;
use Mockery;
use PHPUnit\Framework\TestCase;

class CancelShippingServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFailedService()
    {
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'cancel' => [
                    false,
                    [
                        'status' => false,
                        'text'   => "Failed get shipping data",
                        'data'   => null
                    ]
                ]
            ]);

        $awb = 'OID-8372637';
        $reason = 'mock reason';
        $result = (new CancelShippingService($awb, $reason))->call();

        self::assertFalse($result->status);
        self::assertEquals('Failed get shipping data', $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty()
    {
        $this->tearDown();
        $this->expectException(\TypeError::class);

        $awb = NULL;
        $reason = NULL;
        (new CancelShippingService($awb, $reason))->call();
    }

    public function testIsInteger()
    {
        $this->tearDown();
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'cancel' => [
                    false,
                    [
                        'status' => false,
                        'text'   => "Params must be an string",
                        'data'   => null
                    ]
                ]
            ]);

        $awb = 8372637;
        $reason = 1232;
        $result = (new CancelShippingService($awb, $reason))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params must be an string", $result->message);
        self::assertEquals(null, $result->data);
    }
}
