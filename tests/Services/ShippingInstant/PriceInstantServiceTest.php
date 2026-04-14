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
        $payload->origin = ['lat' => -6.175, 'long' => 106.827, 'address' => 'Jakarta'];
        $payload->destination = ['lat' => -6.200, 'long' => 106.816, 'address' => 'Kebayoran'];
        $payload->item_price = 1000;
        $payload->service = ['grab_express'];
        $payload->vehicle = 'motor';
        $payload->timezone = 'Asia/Jakarta';

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
