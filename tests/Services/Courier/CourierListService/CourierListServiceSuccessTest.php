<?php

namespace KiriminAja\Services\Courier\CourierListService;

require_once(__DIR__ . '/../CourierMock.php');

use KiriminAja\Services\Courier\CourierListService;
use KiriminAja\Services\Courier\CourierMock;
use PHPUnit\Framework\TestCase;

class CourierListServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new CourierMock)->courierMock()
            ->shouldReceive([
                'list' => [
                    true,
                    [
                        'status' => true,
                        'text' => 'loaded',
                        'datas' => [
                            ['code' => 'jne', 'name' => 'JNE'],
                            ['code' => 'sicepat', 'name' => 'SiCepat'],
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $result = (new CourierListService())->call();

        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertIsArray($result->data);
        self::assertCount(2, $result->data);
    }
}
