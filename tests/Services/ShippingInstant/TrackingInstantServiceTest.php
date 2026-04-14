<?php

namespace KiriminAja\Services\ShippingInstant;

use KiriminAja\Repositories\ShippingInstantRepository;
use PHPUnit\Framework\TestCase;

class TrackingInstantServiceTest extends TestCase
{
    public function testIsSuccess()
    {
        \Mockery::close();
        \Mockery::mock("overload:" . ShippingInstantRepository::class)
            ->shouldReceive([
                'tracking' => [
                    true,
                    [
                        'status' => true,
                        'text' => 'Success',
                        'result' => [
                            'order_id' => 'INS-123456',
                            'status' => 'delivered',
                            'driver' => [
                                'name' => 'Driver Mock',
                                'phone' => '08123456789'
                            ]
                        ]
                    ]
                ]
            ]);

        $result = (new TrackingInstantService('INS-123456'))->call();

        self::assertTrue($result->status);
        self::assertEquals('Success', $result->message);
        self::assertIsArray($result->data);
        self::assertEquals('INS-123456', $result->data['order_id']);
    }

    public function testIsFailed()
    {
        \Mockery::close();
        \Mockery::mock("overload:" . ShippingInstantRepository::class)
            ->shouldReceive([
                'tracking' => [
                    false,
                    [
                        'status' => false,
                        'text' => 'Order not found',
                    ]
                ]
            ]);

        $result = (new TrackingInstantService('INVALID'))->call();

        self::assertFalse($result->status);
        self::assertEquals('Order not found', $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty()
    {
        \Mockery::close();
        $this->expectException(\TypeError::class);

        $orderId = null;
        (new TrackingInstantService($orderId))->call();
    }
}
