<?php

namespace KiriminAja\Services\Address\DistrictByNameService;

require_once(__DIR__ . '/../AddressMock.php');

use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\DistrictByNameService;
use KiriminAja\Services\KiriminAja;
use PHPUnit\Framework\TestCase;

class DistrictByNameServiceSuccessTest extends TestCase
{
    public function testSuccess()
    {
        $this->tearDown();
        $district_objects = array(
            (object)[
                [
                    "id" => 1,
                    "text" => "Bogor Barat - Kota, Kota Bogor, Jawa Barat"
                ]
            ]
        );

        \Mockery::mock("overload:" . AddressRepository::class)
            ->shouldReceive([
                'districtsByName' => [
                    true,
                    [
                        "status" => true,
                        "message" => 'loaded',
                        "data" => $district_objects
                    ]
                ]
            ]);

        $name = 'sleman';
        $result = KiriminAja::getDistrictByName($name);

        self::assertTrue($result->status);
        self::assertEquals("loaded", $result->message);
        self::assertEquals($district_objects, $result->data);
    }
}
