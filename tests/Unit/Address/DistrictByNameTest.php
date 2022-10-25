<?php

namespace KiriminAja\Unit\Address;

use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Services\Address\DistrictByNameService;
use PHPUnit\Framework\TestCase;

class DistrictByNameTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        \Mockery::mock("overload:" . AddressRepository::class)
            ->shouldReceive([
                'districtsByName' => [
                    true,
                    [
                        'status'   => true,
                        'text'     => "yess berhasil mock",
                        'endpoint' => 'district by name',
                        'data'     => [
                            'id' => 1
                        ]
                    ]
                ]
            ]);
    }

    public function testSuccess()
    {
        $name = 'sleman';
        $result = (new DistrictByNameService($name))->call();
        self::assertTrue($result->status);
    }
}
