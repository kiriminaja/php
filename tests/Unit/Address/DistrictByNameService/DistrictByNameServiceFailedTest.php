<?php

namespace KiriminAja\Unit\Address\DistrictByNameService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\DistrictByNameService;
use KiriminAja\Unit\Address\AddressMock;
use PHPUnit\Framework\TestCase;
use Mockery;

class DistrictByNameServiceFailedTest extends TestCase
{


    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testFailedNameIsNull()
    {
        (new AddressMock())->addressMock()->shouldReceive(
            [
                'status'      => false,
                'message'     => "Params name Can't be blank",
                'data'        => null
            ]
        );

        $name = NULL;
        $result = (new DistrictByNameService($name))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params name Can't be blank", $result->message);
    }

    public function testFailedNameIsInteger()
    {
        (new AddressMock())->addressMock()->shouldReceive(
            [
                'status'      => false,
                'message'     => "Params name must be an string",
                'data'        => null
            ]
        );

        $name = 12;
        $result = (new DistrictByNameService($name))->call();

        self::assertFalse($result->status);
        self::assertEquals("Params name must be an string", $result->message);
    }
}
