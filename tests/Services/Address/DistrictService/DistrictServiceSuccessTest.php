<?php

namespace KiriminAja\Services\Address\DistrictService;

require_once(__DIR__ . '/../AddressMock.php');

use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\DistrictService;
use PHPUnit\Framework\TestCase;

class DistrictServiceSuccessTest extends TestCase
{
    public function testSuccess()
    {
        \Mockery::close();
        $district_objects = array(
            [
                "id" => 22,
                "provinsi_id" => 9,
                "kabupaten_name" => "Bandung",
                "type" => "Kabupaten",
                "postal_code" => "40311",
                "sentral_name" => "Bandung"
            ]
        );

        \Mockery::mock("overload:" . AddressRepository::class)
            ->shouldReceive([
                'districts' => [
                    true,
                    [
                        'status' => true,
                        'message' => 'loaded',
                        'datas' => $district_objects
                    ]
                ]
            ]);

        $city_id = 12;
        $result = (new DistrictService($city_id))->call();

        self::assertTrue($result->status);
        self::assertEquals("loaded", $result->message);
        self::assertEquals($district_objects[0]['id'], $result->data[0]['id']);
    }
}
