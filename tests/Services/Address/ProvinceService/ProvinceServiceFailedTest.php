<?php

namespace KiriminAja\Services\Address\ProvinceService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\ProvinceService;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProvinceServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function setUp(): void
    {
        parent::setUp();
        (new AddressMock())->addressMock()
            ->shouldReceive([
                'provinces' => [
                    false,
                    [
                        'status' => false
                    ]
                ]
            ]);
    }

    public function test()
    {
        $result = (new ProvinceService())->call();

        self::assertFalse($result->status);
    }
}
