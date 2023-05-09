<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Models\PackageData;
use KiriminAja\Models\RequestPickupData;
use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Services\KiriminAja;
use PHPUnit\Framework\TestCase;

class RequestPickupServiceTest extends TestCase {

    public function testRequestPickupService() {
        \Mockery::close();
        $data = new RequestPickupData;
        $data->name = 'daewu';
        $data->phone = '0873458364587';
        $data->address = 'Jalan jauh banget';
        $data->kecamatan_id = 334;
        $data->schedule = '2022-10-13 08:00:00';
        $data->platform_name = 'daewu';

        $package = new PackageData;
        $package->order_id = 'OID-34756439785';
        $package->destination_name = 'Kakakaka';
        $package->destination_phone = '08547685476';
        $package->destination_address = 'Kakakaka';
        $package->destination_kecamatan_id = 334;
        $package->weight = 230;
        $package->width = 1;
        $package->length = 1;
        $package->height = 1;
        $package->qty = 1;
        $package->item_value = 20000;
        $package->shipping_cost = 20000;
        $package->service = 'jne';
        $package->service_type = 'reg';
        $package->cod = 0;
        $package->package_type_id = 1;
        $package->item_name = 'Kakakaka';
        $package->drop = false;
        $package->note = 'Kakakaka';

        $data->packages = [$package];

        \Mockery::mock("overload:".ShippingRepository::class)
            ->shouldReceive([
                "requestPickup" => [
                    true,
                    [
                        "status" => true,
                        "text" => "Success",
                        "pickup_number" => "Floo",
                        "payment_status" => "paid",
                        "details" => [
                            "Joko" => true
                        ]
                    ]
                ]
            ]);

        $service = KiriminAja::requestPickup($data);

        self::assertTrue($service->status);
    }

}
