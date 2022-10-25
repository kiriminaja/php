<?php

namespace KiriminAja\Unit\Address;

use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Services\Address\CityService;
use PHPUnit\Framework\TestCase;

class CityServiceTest extends TestCase
{
    public function testSuccess()
    {
        $this->addressMock()
            ->shouldReceive([
                'cities' => [
                    true,
                    [
                        'status'   => true,
                        'text'     => 'mock success',
                        'endpoint' => 'city'
                    ]
                ]
            ]);
        $province_id = 11;
        $result = (new CityService($province_id))->call();

        self::assertTrue($result->status);
    }

    public function addressMock()
    {
        return \Mockery::mock("overload:" . AddressRepository::class);
    }
}
