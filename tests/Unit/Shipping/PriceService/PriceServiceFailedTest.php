<?php

namespace KiriminAja\Unit\Shipping\PriceService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Services\Shipping\PriceService;
use KiriminAja\Unit\Shipping\ShippingMock;
use PHPUnit\Framework\TestCase;
use Mockery;

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

        $shipping_price_object = new ShippingPriceData;
        $shipping_price_object->origin = null;
        $shipping_price_object->destination = null;
        $shipping_price_object->weight = null;
        $shipping_price_object->insurance = null;
        $shipping_price_object->item_value = null;
        $shipping_price_object->courier = null;

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'price' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => "Params origin, destination, weight Can't be blank",
                        'data'    => null
                    ]
                ]
            ]);


        $result = (new PriceService($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params origin, destination, weight Can't be blank", $result->message);
        self::assertEquals(null, $result->data);

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'price' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => "Params origin, destination, weight Can't be blank",
                        'data'    => null
                    ]
                ]
            ]);

        $shipping_price_object->insurance = 1;
        $shipping_price_object->item_value = 10000;
        $shipping_price_object->courier = ['jne'];

        $result = (new PriceService($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params origin, destination, weight Can't be blank", $result->message);
        self::assertEquals(null, $result->data);
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
