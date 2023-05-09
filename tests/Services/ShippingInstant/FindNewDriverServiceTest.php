<?php

namespace KiriminAja\Services\ShippingInstant;

use KiriminAja\Repositories\ShippingInstantRepository;
use PHPUnit\Framework\TestCase;

class FindNewDriverServiceTest extends TestCase
{
    public function testIsSuccess()
    {
        \Mockery::close();
        \Mockery::mock("overload:" . ShippingInstantRepository::class)
            ->shouldReceive([
                "findNewDriver" => [
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

        $result = (new FindNewDriverService("BALOO"))->call();

        self::assertTrue($result->status);
    }
}
