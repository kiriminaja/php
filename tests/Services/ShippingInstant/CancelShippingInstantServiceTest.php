<?php

namespace KiriminAja\Services\ShippingInstant;

use KiriminAja\Repositories\ShippingInstantRepository;
use PHPUnit\Framework\TestCase;

class CancelShippingInstantServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsSuccess()
    {
        $this->tearDown();

        \Mockery::mock("overload:".ShippingInstantRepository::class)
            ->shouldReceive([
                "cancel" => [
                    true,
                    [
                        "status" => true,
                        "text" => "loaded",
                        "result" => [
                            "status" => true
                        ]
                    ]
                ]
            ])->once();

        $result = (new CancelShippingInstantService("FOIP"))->call();

        self::assertTrue($result->status);
    }
}
