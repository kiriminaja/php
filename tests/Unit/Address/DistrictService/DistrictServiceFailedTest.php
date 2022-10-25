<?php

namespace KiriminAja\Unit\Address\DistrictService;

use KiriminAja\Services\Address\DistrictService;
use PHPUnit\Framework\TestCase;

class DistrictServiceFailedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        (new DistrictTest())->addressMock()
            ->shouldReceive([
                'districts' => [
                    true,
                    [
                        'status'   => false,
                        'text'     => "mock district not found",
                        'endpoint' => 'districts'
                    ]
                ]
            ]);
    }

    public function test()
    {
        $city_id = 12;
        $result = (new DistrictService($city_id))->call();
        json_encode($result);
        self::assertFalse($result->status);
    }
}
