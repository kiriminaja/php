<?php

namespace KiriminAja\Unit\Shipping\TrackingService;

use KiriminAja\Services\Shipping\TrackingService;
use KiriminAja\Unit\Shipping\ShipppingMock;
use PHPUnit\Framework\TestCase;

class TrackingServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        (new ShipppingMock())->shippingMock()
            ->shouldReceive([
                'tracking' => [
                    true,
                    [
                        'status'      => true,
                        'text'        => 'Success to get tracking data',
                        'status_code' => 200,
                        'details'     => [
                            'detail 1',
                            'detail 2'
                        ],
                        'histories'   => [
                            'track 1',
                            'track 2'
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $order_id = 'OID-MOCK123';
        $result = (new TrackingService($order_id))->call();
        self::assertTrue($result->status);
    }
}
