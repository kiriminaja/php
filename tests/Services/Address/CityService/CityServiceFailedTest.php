<?php

namespace KiriminAja\Services\Address\CityService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\CityService;
use Mockery;
use PHPUnit\Framework\TestCase;

class CityServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
       Mockery::close();
    }

    public function testFailed()
    {
        $this->expectException(\Throwable::class);

        $province_id = "KOPI";
        (new CityService($province_id))->call();
    }
}
