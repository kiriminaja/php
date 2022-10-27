<?php

namespace KiriminAja\Unit\Shipping\GetPaymentService;

use KiriminAja\Services\Shipping\GetPaymentService;
use KiriminAja\Unit\Shipping\ShipppingMock;
use PHPUnit\Framework\TestCase;

class GetPaymentServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        (new ShipppingMock())->shippingMock()
            ->shouldReceive([
                'payment' => [
                    true,
                    [
                        'status' => true,
                        'text'   => "Success get shipping payment data",
                        'data'   => [
                            'id'   => 463,
                            'name' => 'Mock shipping data'
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $payment_id = 123;
        $result = (new GetPaymentService($payment_id))->call();
        self::assertTrue($result->status);
    }
}
