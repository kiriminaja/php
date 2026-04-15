<?php

namespace KiriminAja\Services\Address\SubDistrictService;

require_once(__DIR__ . '/../AddressMock.php');

use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\SubDistrictService;
use PHPUnit\Framework\TestCase;

class SubDistrictServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new AddressMock)->addressMock()
            ->shouldReceive([
                'subDistricts' => [
                    true,
                    [
                        'status' => true,
                        'text' => 'loaded',
                        'results' => [
                            [
                                'id' => 1,
                                'name' => 'Kelurahan A',
                                'kecamatan_id' => 100
                            ],
                            [
                                'id' => 2,
                                'name' => 'Kelurahan B',
                                'kecamatan_id' => 100
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $result = (new SubDistrictService(100))->call();

        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertIsArray($result->data);
        self::assertCount(2, $result->data);
    }
}
