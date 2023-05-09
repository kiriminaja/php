<?php

namespace KiriminAja\Services\Shipping\GetPaymentService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Services\Shipping\GetPaymentService;
use KiriminAja\Services\Shipping\ShippingMock;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetPaymentServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testIsEmpty(){
        $this->tearDown();
        $this->expectException(\TypeError::class);

        $payment_id = NULL;
        (new GetPaymentService($payment_id))->call();
    }
}
