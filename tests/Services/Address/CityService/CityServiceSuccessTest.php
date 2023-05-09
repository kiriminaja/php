<?php

namespace KiriminAja\Services\Address\CityService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\CityService;
use PHPUnit\Framework\TestCase;

class CityServiceSuccessTest extends TestCase
{
    public function testSuccess()
    {
        $this->tearDown();
        $cities_objects = array(
            (object)
                [
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
                'cities' => [
                    true,
                    [
                        "status" => true,
                        "message" => "loaded",
                        "data" => $cities_objects
                    ]
                ]
            ]);

        $province_id = 11;
        $result = (new CityService($province_id))->call();

//        error_log(json_encode($result->data['data'], JSON_PRETTY_PRINT));

        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertEquals($cities_objects, $result->data['data']);
    }
}
