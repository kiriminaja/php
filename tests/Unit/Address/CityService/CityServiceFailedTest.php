<?php

namespace KiriminAja\Unit\Address\CityService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\CityService;
use KiriminAja\Unit\Address\AddressMock;
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
        (new AddressMock())->addressMock()
            ->shouldReceive(
                [
                    'status'   => false,
                    'message'     => 'Params province_id must be in integer',
                    'data' => null
                ]
            );

        $province_id = "11";
        $result = (new CityService($province_id))->call();


        self::assertFalse($result->status);
        self::assertEquals('Params province_id must be in integer', $result->message);
    }
}
