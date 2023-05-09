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
        $package->destination_lat = 1.000;
        $package->destination_long = 1.000;
        $package->destination_address = "JO";
        $package->destination_name = "G";
        $package->item_price = 10000;
        $package->item_description = "BUKU";
        $package->item_name = "BUKU";
        $package->item_weight_in_kg = 1;

        $pickup = new RequestPickupInstantData();
        $pickup->service = "gosend";
        $pickup->service_type = "sql";
        $pickup->vehicle_name = "motor";
        $pickup->insurance_type = "gold";

        $package2 = $package;
        $package2->destination_name = "GOP";

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
        $pickup->vehicle_name = "motor";
        $pickup->insurance_type = "gold";

        $package = new \stdClass();

        KiriminAja::requestPickupInstant($pickup, $package);
    }
}
