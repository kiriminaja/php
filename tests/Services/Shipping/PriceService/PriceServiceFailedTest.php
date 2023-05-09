<?php

namespace KiriminAja\Services\Shipping\PriceService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Services\Shipping\PriceService;
use KiriminAja\Services\Shipping\ShippingMock;
use Mockery;
use PHPUnit\Framework\TestCase;

class PriceServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFailedService()
    {
        Mockery::close();

        $shipping_price_object = new ShippingPriceData;
        $shipping_price_object->origin = 1063;
        $shipping_price_object->destination = 1064;
        $shipping_price_object->weight = 1000;
        $shipping_price_object->insurance = 1;
        $shipping_price_object->item_value = 100000;
        $shipping_price_object->courier = ['jne'];

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'price' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => 'Failed to get shipping mock data',
                        'data'    => null
                    ]
                ]
            ]);

        $result = (new PriceService($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals('Failed to get shipping mock data', $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty(){
        $this->tearDown();
        $this->expectException(\TypeError::class);
        $shipping_price_object = new ShippingPriceData;
        $shipping_price_object->destination = null;

        (new PriceService($shipping_price_object))->call();
    }


    public function testIsString()
    {

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'price' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => "Params origin, destination, weight must be an integers",
                        'data'    => null
                    ]
                ]
            ]);

        $shipping_price_object = new ShippingPriceData;
        $shipping_price_object->origin = "1";
        $shipping_price_object->destination = "2";
        $shipping_price_object->weight = "1000";
        $shipping_price_object->insurance = 1;
        $shipping_price_object->item_value = 10000;
        $shipping_price_object->courier = ['jne'];


        $result = (new PriceService($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params origin, destination, weight must be an integers", $result->message);
        self::assertEquals(null, $result->data);
    }
}
