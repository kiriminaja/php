<?php

namespace KiriminAja\Services\Courier\CourierGroupService;

require_once(__DIR__ . '/../CourierMock.php');

use KiriminAja\Services\Courier\CourierGroupService;
use KiriminAja\Services\Courier\CourierMock;
use Mockery;
use PHPUnit\Framework\TestCase;

class CourierGroupServiceFailedTest extends TestCase
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
                'group' => [
                    false,
                    [
                        'status' => false,
                        'text' => 'Failed to fetch courier groups',
                        'data' => null
                    ]
                ]
            ]);

        $result = (new CourierGroupService())->call();

        self::assertFalse($result->status);
        self::assertEquals('Failed to fetch courier groups', $result->message);
        self::assertEquals(null, $result->data);
    }
}
