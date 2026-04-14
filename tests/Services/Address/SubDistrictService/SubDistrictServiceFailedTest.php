<?php

namespace KiriminAja\Services\Address\SubDistrictService;

require_once(__DIR__ . '/../AddressMock.php');

use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\SubDistrictService;
use Mockery;
use PHPUnit\Framework\TestCase;

class SubDistrictServiceFailedTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFailedService()
    {
        Mockery::close();
        (new AddressMock)->addressMock()
            ->shouldReceive([
                'subDistricts' => [
                    false,
                    [
                        'status' => false,
                        'text' => 'Failed to fetch sub-districts',
                        'data' => null
                    ]
                ]
            ]);

        $result = (new SubDistrictService(999))->call();

        self::assertFalse($result->status);
        self::assertEquals('Failed to fetch sub-districts', $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty()
    {
        $this->tearDown();
        $this->expectException(\TypeError::class);

        $districtId = null;
        (new SubDistrictService($districtId))->call();
    }
}
