<?php

namespace KiriminAja\Services\ShippingInstant;

use KiriminAja\Repositories\ShippingInstantRepository;
use KiriminAja\Services\KiriminAja;
use PHPUnit\Framework\TestCase;

class GetPaymentInstantServiceTest extends TestCase
{
    public function testIsSuccess()
    {
        \Mockery::close();
        \Mockery::mock("overload:" . ShippingInstantRepository::class)
            ->shouldReceive([
                'getPayment' => [
                    true,
                    [
                        "status" => true,
                        "text" => "loaded",
                        "result" => [
                            "status" => true
                        ]
                    ]
                ]
            ]);

        $call = KiriminAja::getPayment("X", true);

        self::assertTrue($call->status);
    }
}
