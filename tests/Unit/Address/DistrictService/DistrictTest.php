<?php

namespace KiriminAja\Unit\Address\DistrictService;

use KiriminAja\Repositories\AddressRepository;
use PHPUnit\Framework\TestCase;

class DistrictTest extends TestCase
{
    public function addressMock()
    {
        return \Mockery::mock("overload:".AddressRepository::class);
    }
}
