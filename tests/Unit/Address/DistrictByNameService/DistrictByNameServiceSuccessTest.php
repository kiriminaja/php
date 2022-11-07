<?php

namespace KiriminAja\Unit\Address\DistrictByNameService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\DistrictByNameService;
use KiriminAja\Unit\Address\AddressMock;
use PHPUnit\Framework\TestCase;

class DistrictByNameServiceSuccessTest extends TestCase
{
    public function testSuccess()
    {

        $district_objects = array(
            (object) [
                [
                    "id" => 1,
                    "text" => "Bogor Barat - Kota, Kota Bogor, Jawa Barat"
                ]
            ]
        );

        (new AddressMock())->addressMock()->shouldReceive([
            'districtsByName' => [
                true,
                [
                    "status"   => true,
                    "message" => 'loaded',
                    "data"     => $district_objects
                ]
            ]
        ]);
        $name = 'sleman';
        $result = (new DistrictByNameService($name))->call();

        self::assertTrue($result->status);
        self::assertEquals("loaded", $result->message);
        self::assertEquals($district_objects, $result->data);
    }
}
