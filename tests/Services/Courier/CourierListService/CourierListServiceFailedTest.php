<?php

namespace KiriminAja\Services\Courier\CourierListService;

require_once(__DIR__ . '/../CourierMock.php');

use KiriminAja\Services\Courier\CourierListService;
use KiriminAja\Services\Courier\CourierMock;
use Mockery;
use PHPUnit\Framework\TestCase;

class CourierListServiceFailedTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFailedService()
    {
        Mockery::close();
        (new CourierMock)->courierMock()
            ->shouldReceive([
                'list' => [
                    false,
                    [
                        'status' => false,
                        'text' => 'Failed to fetch couriers',
                        'data' => null
                    ]
                ]
            ]);

        $result = (new CourierListService())->call();

        self::assertFalse($result->status);
        self::assertEquals('Failed to fetch couriers', $result->message);
        self::assertEquals(null, $result->data);
    }
}
