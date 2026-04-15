<?php

namespace KiriminAja\Services\Courier\CourierGroupService;

require_once(__DIR__ . '/../CourierMock.php');

use KiriminAja\Services\Courier\CourierGroupService;
use KiriminAja\Services\Courier\CourierMock;
use PHPUnit\Framework\TestCase;

class CourierGroupServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new CourierMock)->courierMock()
            ->shouldReceive([
                'group' => [
                    true,
                    [
                        'status' => true,
                        'text' => 'loaded',
                        'datas' => [
                            ['group' => 'regular', 'couriers' => ['jne', 'sicepat']],
                            ['group' => 'instant', 'couriers' => ['gosend', 'grab']],
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $result = (new CourierGroupService())->call();

        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertIsArray($result->data);
        self::assertCount(2, $result->data);
    }
}
