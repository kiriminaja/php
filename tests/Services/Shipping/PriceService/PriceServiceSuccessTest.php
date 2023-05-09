<?php

namespace KiriminAja\Services\Shipping\PriceService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Services\Shipping\PriceService;
use KiriminAja\Services\Shipping\ShippingMock;
use PHPUnit\Framework\TestCase;

class PriceServiceSuccessTest extends TestCase
{

    public function test()
    {
        \Mockery::close();
        $price_object = (object) [
            'details' => [
                "origin" => "Bogor Selatan - Kota",
                "destination" => "Bogor Tengah - Kota",
                "weight" => "1000"
            ],
            'results' => [
                "service" => "jne",
                "service_name" => "JNE City to City",
                "service_type" => "CTC",
                "cost" => "9000",
                "etd" => "1-2",
                "cod" => true,
                "group" => "regular",
                "drop" => true,
                "setting" => (object) [
                    "cod_fee" => "0.03",
                    "minimum_cod_fee" => "2500",
                    "insurance_fee" => "0.002",
                    "insurance_add_cost" => "5000"
                ]
            ]
        ];

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'price' => [
                    true,
                    [
                        'status'  => true,
                        'text'    => 'loaded',
                        'details' => $price_object->details,
                        'results' => $price_object->results
                    ]
                ]
            ]);

        $shipping_price_object = new ShippingPriceData;
        $shipping_price_object->origin = 1063;
        $shipping_price_object->destination = 1064;
        $shipping_price_object->weight = 1000;
        $shipping_price_object->insurance = 1;
        $shipping_price_object->item_value = 100000;
        $shipping_price_object->courier = ['jne'];

        $result = (new PriceService($shipping_price_object))->call();


        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertEquals($price_object->details, $result->data['details']);
        self::assertEquals($price_object->results, $result->data['results']);
    }
}
