<?php

namespace KiriminAja\Unit\Shipping\GetPaymentService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Services\Shipping\GetPaymentService;
use KiriminAja\Unit\Shipping\ShippingMock;
use PHPUnit\Framework\TestCase;
use Mockery;

class GetPaymentServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testIsInteger()
    {
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'payment' => [
                    false,
                    [
                        'status' => false,
                        'text'   => "payment_id Params must be an string",
                        'data'   => null
                    ]
                ]
            ]);

        $payment_id = 123;
        $result = (new GetPaymentService($payment_id))->call();

        self::assertFalse($result->status);
        self::assertEquals('payment_id Params must be an string', $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty(){
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'payment' => [
                    false,
                    [
                        'status' => false,
                        'text'   => "payment_id Params Can't be blank",
                        'data'   => null
                    ]
                ]
            ]);


        $payment_id = NULL;
        $result = (new GetPaymentService($payment_id))->call();

        self::assertFalse($result->status);
        self::assertEquals("payment_id Params Can't be blank", $result->message);
        self::assertEquals(null, $result->data);
    }
}
