<?php

namespace KiriminAja\Unit\Shipping\RequestPickupService;

use KiriminAja\Models\RequestPickupData;
use KiriminAja\Services\Shipping\RequestPickupService;
use KiriminAja\Unit\Shipping\ShipppingMock;
use PHPUnit\Framework\TestCase;

class RequestPickupServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        (new ShipppingMock())->shippingMock()
            ->shouldReceive([
                'requestPickup' => [
                    true,
                    [
                        'status'         => true,
                        'text'           => 'Success to fetch shipping pickup data',
                        'pickup_number'  => '123mocknumber',
                        'payment_status' => 'paid',
                        'details'        => [
                            'id'   => 12,
                            'name' => 'value mock'
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $param = new RequestPickupData();
        $result = (new RequestPickupService($param))->call();
        self::assertTrue($result->status);
    }
}
