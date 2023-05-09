<?php

namespace KiriminAja\Services\Address\DistrictByNameService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\DistrictByNameService;
use Mockery;
use PHPUnit\Framework\TestCase;

class DistrictByNameServiceFailedTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @return void
     */
    public function testFailedNameIsNull()
    {
        $this->expectException(\TypeError::class);
        $name = NULL;
        (new DistrictByNameService($name))->call();
    }

    public function testFailedNameIsFloat()
    {
        $this->expectException(\TypeError::class);
        $name = (object) [
            'status' => true
        ];
        (new DistrictByNameService($name))->call();
    }
}
