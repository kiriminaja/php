<?php

namespace KiriminAja\Unit\Address\DistrictService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\DistrictService;
use KiriminAja\Unit\Address\AddressMock;
use PHPUnit\Framework\TestCase;

class DistrictServiceSuccessTest extends TestCase
{
    public function testSuccess()
    {

        $district_objects  = array(
            (object) [
                "id" => 22,
                "provinsi_id" => 9,
                "kabupaten_name" => "Bandung",
                "type" => "Kabupaten",
                "postal_code" => "40311",
                "sentral_name" => "Bandung"
            ]
        );

        (new AddressMock())->addressMock()
            ->shouldReceive([
                'districts' => [
                    true,
                    [
                        'status'   => true,
                        'message'  => 'loaded',
                        'datas'    => $district_objects
                    ]
                ]
            ]);

        $city_id = 12;
        $result = (new DistrictService($city_id))->call();

        self::assertTrue($result->status);
        self::assertEquals("loaded", $result->message);
        self::assertEquals($district_objects, $result->data);
    }
}
