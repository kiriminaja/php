<?php

namespace KiriminAja\Unit\Shipping\FullShippingPrice;

use KiriminAja\Models\ShippingFullPriceData;
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Services\Shipping\FullShippingPrice;
use KiriminAja\Unit\Shipping\ShippingMock;
use Mockery;
use PHPUnit\Framework\TestCase;

require_once(__DIR__.'/../ShippingMock.php');

class FullShippingPriceFailedTest extends TestCase
{

    public function testFailedService()
    {
        Mockery::close();
        $shipping_price_object = new ShippingFullPriceData();
        $shipping_price_object->origin = 1063;
        $shipping_price_object->destination = 1064;
        $shipping_price_object->weight = 1000;

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'fullShippingPrice' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => 'Failed to get shipping mock data',
                        'data'    => null
                    ]
                ]
            ]);

        $result = (new fullShippingPrice($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals('Failed to get shipping mock data', $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty(){
        Mockery::close();
        $shipping_price_object = new ShippingFullPriceData();
        $shipping_price_object->origin = null;
        $shipping_price_object->destination = null;
        $shipping_price_object->weight = null;

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'fullShippingPrice' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => "Params origin, destination, weight Can't be blank",
                        'data'    => null
                    ]
                ]
            ]);


        $result = (new fullShippingPrice($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params origin, destination, weight Can't be blank", $result->message);
        self::assertEquals(null, $result->data);

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'fullShippingPrice' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => "Params origin, destination, weight Can't be blank",
                        'data'    => null
                    ]
                ]
            ]);

        $result = (new fullShippingPrice($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params origin, destination, weight Can't be blank", $result->message);
        self::assertEquals(null, $result->data);
    }


    public function testIsString()
    {
        Mockery::close();
        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'fullShippingPrice' => [
                    false,
                    [
                        'status'  => false,
                        'text'    => "Params origin, destination, weight must be an integers",
                        'data'    => null
                    ]
                ]
            ]);

        $shipping_price_object = new ShippingFullPriceData();
        $shipping_price_object->origin = "1";
        $shipping_price_object->destination = "2";
        $shipping_price_object->weight = "1000";


        $result = (new fullShippingPrice($shipping_price_object))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params origin, destination, weight must be an integers", $result->message);
        self::assertEquals(null, $result->data);
    }
}
