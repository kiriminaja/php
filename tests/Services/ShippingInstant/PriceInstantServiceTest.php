<?php

namespace KiriminAja\Services\ShippingInstant;

use KiriminAja\Models\ShippingPriceInstantData;
use KiriminAja\Repositories\ShippingInstantRepository;
use KiriminAja\Services\KiriminAja;
use PHPUnit\Framework\TestCase;

class PriceInstantServiceTest extends TestCase
{
    public function testSuccess()
    {
        \Mockery::close();
        \Mockery::mock("overload:" . ShippingInstantRepository::class)
            ->shouldReceive([
                'price' => [
                    true,
                    [
                        "status" => true,
                        "text" => "success",
                        "result" => "Success"
                    ]
                ]
            ]);

        $payload = (new ShippingPriceInstantData());
        $payload->weight = 1000;
        $payload->origin_address = "BOKO";
        $payload->origin_long = 1.00;
        $payload->origin_lat = 1.00;
        $payload->destination_address = "BOKO";
        $payload->destination_long = 1.00;
        $payload->destination_lat = 1.00;
        $payload->item_price = 1000;

        $call = KiriminAja::getPriceInstant($payload);

        self::assertTrue($call->status);
    }

    public function testInvalid()
    {
        \Mockery::close();
        $this->expectException(\TypeError::class);

        KiriminAja::getPriceInstant("BECAK");
    }

    public function testInvalidData()
    {
        \Mockery::close();
        $this->expectException(\Error::class);

        $payload = (new ShippingPriceInstantData());
        $payload->weight = "JOKO";

        KiriminAja::getPriceInstant($payload);
    }
}
