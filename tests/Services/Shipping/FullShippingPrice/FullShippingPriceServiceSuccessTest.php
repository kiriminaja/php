<?php
namespace KiriminAja\Services\Shipping\FullShippingPrice;

use KiriminAja\Models\ShippingFullPriceData;
use KiriminAja\Services\Shipping\FullShippingPrice;
use KiriminAja\Services\Shipping\ShippingMock;
use Mockery;
use PHPUnit\Framework\TestCase;

require_once(__DIR__.'/../ShippingMock.php');

class FullShippingPriceServiceSuccessTest extends TestCase
{

    public function test()
    {
        Mockery::close();
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
                'fullShippingPrice' => [
                    true,
                    [
                        'status'  => true,
                        'text'    => 'loaded',
                        'details' => $price_object->details,
                        'results' => $price_object->results
                    ]
                ]
            ]);

        $shipping_price_object = new ShippingFullPriceData();
        $shipping_price_object->origin = 1063;
        $shipping_price_object->destination = 1064;
        $shipping_price_object->weight = 1000;

        $result = (new FullShippingPrice($shipping_price_object))->call();


        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertEquals($price_object->details, $result->data['details']);
        self::assertEquals($price_object->results, $result->data['results']);
    }
}
