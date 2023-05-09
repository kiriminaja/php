<?php

namespace KiriminAja\Services\Shipping\RequestPickupService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Models\PackageData;
use KiriminAja\Models\RequestPickupData;
use KiriminAja\Services\Shipping\RequestPickupService;
use KiriminAja\Services\Shipping\ShippingMock;
use PHPUnit\Framework\TestCase;

class RequestPickupServiceSuccessTest extends TestCase
{
    public function test()
    {
        \Mockery::close();
        $expect_object = [
            "pickup_number"  => '123mocknumber',
            "payment_status" => 'paid',
            "details"        => [
                (object) [
                    "order_id" => "DEV-2300000024",
                    "kj_order_id" => "DEV-2300000024",
                    "awb" => null,
                    "service" => "SICEPAT",
                    "service_type" => "SIUNT"
                ]
            ]
        ];

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'requestPickup' => [
                    true,
                    [
                        'status'         => true,
                        'text'           => 'loaded',
                        'pickup_number'  => $expect_object['pickup_number'],
                        'payment_status' => $expect_object['payment_status'],
                        'details'        => $expect_object['details']
                    ]
                ]
            ]);

        $pickup_object = new RequestPickupData;
        $pickup_object->address = "Jl. Jodipati No.29 Perum Taman Kencana Sejahtera";
        $pickup_object->phone = "082129627860";
        $pickup_object->name = "dipaferdian";
        $pickup_object->kecamatan_id = 5784;
        $pickup_object->schedule = "2022-11-03 17:00:00";
        $pickup_object->zipcode = 16610;
        $pickup_object->platform_name = 'mitra';
        $pickup_object->packages = [];

        $package_data = new PackageData;
        $package_data->order_id = "DEV-2300000024";
        $package_data->destination_name = "Flag Test3";
        $package_data->destination_phone = "082223323333";
        $package_data->destination_address = "Jl. Magelang KM 11";
        $package_data->destination_kecamatan_id = 419;
        $package_data->destination_zipcode = 55598;
        $package_data->weight = 520;
        $package_data->width = 8;
        $package_data->height = 8;
        $package_data->length = 8;
        $package_data->item_value = 275000;
        $package_data->shipping_cost = 65000;
        $package_data->service = "sicepat";
        $package_data->service_type = "SIUNT";
        $package_data->item_name = "Test item name";
        $package_data->package_type_id = 1;
        $package_data->cod = 0;
        $package_data->note = 'test pickup request non cod';
        $package_data->drop = true;
        $pickup_object->packages = [$package_data];

        $result = (new RequestPickupService($pickup_object))->call();

        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertEquals($expect_object, $result->data);
    }
}
