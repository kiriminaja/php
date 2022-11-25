<?php

namespace KiriminAja\Unit\Address\DistrictService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\DistrictService;
use KiriminAja\Unit\Address\AddressMock;
use PHPUnit\Framework\TestCase;
use Mockery;

class DistrictServiceFailedTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function setUp(): void
    {
        parent::setUp();
        (new AddressMock())->addressMock()
            ->shouldReceive(
                    [
                        'status'   => false,
                        'message'     => "Params city_id must be in integer",
                        'data' => null
                    ]
            );
    }

    public function test()
    {
        $city_id = "12";
        $result = (new DistrictService($city_id))->call();

        self::assertFalse($result->status);
        self::assertEquals('Params city_id must be in integer', $result->message);
    }
}
