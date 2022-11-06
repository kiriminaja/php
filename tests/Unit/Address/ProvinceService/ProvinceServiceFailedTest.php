<?php

namespace KiriminAja\Unit\Address\ProvinceService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Services\Address\ProvinceService;
use KiriminAja\Unit\Address\AddressMock;
use PHPUnit\Framework\TestCase;
use Mockery;

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
