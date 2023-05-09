<?php

namespace KiriminAja\Services\Shipping\ScheduleService;

require_once(__DIR__.'/../ShippingMock.php');

use KiriminAja\Services\Shipping\ScheduleService;
use KiriminAja\Services\Shipping\ShippingMock;
use Mockery;
use PHPUnit\Framework\TestCase;

class ScheduleServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test()
    {
        Mockery::close();

        (new ShippingMock())->shippingMock()
            ->shouldReceive([
                'schedules' => [
                    false,
                    [
                        'status'    => false,
                        'text'      => 'Failed to fetch schedules data'
                    ]
                ]
            ]);


        $result = (new ScheduleService())->call();

        self::assertFalse($result->status);
        self::assertEquals('Failed to fetch schedules data', $result->message);
        self::assertEquals(null, $result->data);
    }
}
