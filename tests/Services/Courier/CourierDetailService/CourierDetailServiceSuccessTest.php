<?php

namespace KiriminAja\Services\Courier\CourierDetailService;

require_once(__DIR__ . '/../CourierMock.php');

use KiriminAja\Services\Courier\CourierDetailService;
use KiriminAja\Services\Courier\CourierMock;
use PHPUnit\Framework\TestCase;

class CourierDetailServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new CourierMock)->courierMock()
            ->shouldReceive([
                'detail' => [
                    true,
                    [
                        'status' => true,
                        'text' => 'loaded',
                        'datas' => [
                            'code' => 'jne',
                            'name' => 'JNE',
                            'services' => [
                                ['type' => 'REG', 'name' => 'Regular'],
                                ['type' => 'YES', 'name' => 'Yakin Esok Sampai'],
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $result = (new CourierDetailService('jne'))->call();

        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertIsArray($result->data);
        self::assertEquals('jne', $result->data['code']);
    }
}
