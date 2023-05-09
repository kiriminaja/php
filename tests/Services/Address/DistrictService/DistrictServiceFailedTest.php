<?php

namespace KiriminAja\Services\Address\DistrictService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\DistrictService;
use Mockery;
use PHPUnit\Framework\TestCase;

class DistrictServiceFailedTest extends TestCase
{
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
        Mockery::close();
        $this->expectException(\TypeError::class);

        $city_id = "BECAK";
        (new DistrictService($city_id))->call();
    }
}
