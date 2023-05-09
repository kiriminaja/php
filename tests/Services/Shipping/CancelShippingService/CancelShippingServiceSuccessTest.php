<?php

namespace KiriminAja\Services\Shipping\CancelShippingService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Services\Shipping\CancelShippingService;
use KiriminAja\Services\Shipping\ShippingMock;
use PHPUnit\Framework\TestCase;

class CancelShippingServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'cancel' => [
                    true,
                    [
                        'status' => true,
                        'text'   => "Success get shipping data",
                        'data'  => [
                            'id'   => 987,
                            'name' => "shipping mock data"
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {

        $expect = [
            'id'   => 987,
            'name' => "shipping mock data"
        ];

        $awb = 'OID-8372637';
        $reason = 'mock reason';
        $result = (new CancelShippingService($awb, $reason))->call();

        self::assertTrue($result->status);
        self::assertEquals('Success get shipping data', $result->message);
        self::assertEquals($expect, $result->data);
    }
}
