<?php

namespace KiriminAja\Services\Courier\CourierDetailService;

require_once(__DIR__ . '/../CourierMock.php');

use KiriminAja\Services\Courier\CourierDetailService;
use KiriminAja\Services\Courier\CourierMock;
use Mockery;
use PHPUnit\Framework\TestCase;

class CourierDetailServiceFailedTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFailedService()
    {
        (new CourierMock)->courierMock()
            ->shouldReceive([
                'detail' => [
                    false,
                    [
                        'status' => false,
                        'text' => 'Courier not found',
                        'data' => null
                    ]
                ]
            ]);

        $result = (new CourierDetailService('unknown'))->call();

        self::assertFalse($result->status);
        self::assertEquals('Courier not found', $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty()
    {
        $this->tearDown();
        $this->expectException(\TypeError::class);

        $courierCode = null;
        (new CourierDetailService($courierCode))->call();
    }
}
