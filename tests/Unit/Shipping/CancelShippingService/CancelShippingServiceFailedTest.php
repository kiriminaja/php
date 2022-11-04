<?php

namespace KiriminAja\Unit\Shipping\CancelShippingService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Services\Shipping\CancelShippingService;
use KiriminAja\Unit\Shipping\ShippingMock;
use PHPUnit\Framework\TestCase;
use Mockery;

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
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'cancel' => [
                    false,
                    [
                        'status' => false,
                        'text'   => "Params Can't be blank",
                        'data'   => null
                    ]
                ]
            ]);

        $awb = NULL;
        $reason = NULL;
        $result = (new CancelShippingService($awb, $reason))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params Can't be blank", $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsInteger()
    {
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
