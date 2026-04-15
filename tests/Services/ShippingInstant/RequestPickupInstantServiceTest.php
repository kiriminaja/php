<?php

namespace KiriminAja\Services\ShippingInstant;

use KiriminAja\Models\PackageInstantData;
use KiriminAja\Models\RequestPickupInstantData;
use KiriminAja\Repositories\ShippingInstantRepository;
use KiriminAja\Services\KiriminAja;
use PHPUnit\Framework\TestCase;

class RequestPickupInstantServiceTest extends TestCase
{
    public function testSuccess()
    {
        \Mockery::close();

        \Mockery::mock("overload:" . ShippingInstantRepository::class)
            ->shouldReceive([
                "create" => [
                    true,
                    [
                        "status" => true,
                        "text" => "Success",
                        "result" => [
                            "payment" => [
                                "payment_id"
                            ]
                        ]
                    ]
                ]
            ]);

        $package = new PackageInstantData();
        $package->origin_lat = 1.000;
        $package->origin_long = 1.000;
        $package->origin_address = "JO";
        $package->origin_name = "G";
        $package->origin_phone = "08123456789";
        $package->origin_address_note = "Near gate";
        $package->destination_lat = 1.000;
        $package->destination_long = 1.000;
        $package->destination_address = "JO";
        $package->destination_name = "G";
        $package->destination_phone = "08987654321";
        $package->destination_address_note = "Floor 2";
        $package->shipping_price = 15000;
        $package->item_price = 10000;
        $package->item_description = "BUKU";
        $package->item_name = "BUKU";
        $package->item_weight = 1000;

        $pickup = new RequestPickupInstantData();
        $pickup->service = "gosend";
        $pickup->service_type = "sql";
        $pickup->vehicle = "motor";
        $pickup->order_prefix = "DEV";

        $call = KiriminAja::requestPickupInstant($pickup, $package);
        self::assertTrue($call->status);
    }

    public function testInvalid()
    {
        \Mockery::close();
        $this->expectException(\TypeError::class);

        $pickup = new RequestPickupInstantData();
        $pickup->service = "gosend";
        $pickup->service_type = "sql";
        $pickup->vehicle = "motor";
        $pickup->order_prefix = "DEV";

        $package = new \stdClass();

        KiriminAja::requestPickupInstant($pickup, $package);
    }
}
