<?php

namespace KiriminAja\Services\Address;

use KiriminAja\Repositories\AddressRepository;
use PHPUnit\Framework\TestCase;

class AddressMock extends TestCase
{
    public function addressMock()
    {
        return \Mockery::mock("overload:".AddressRepository::class);
    }
}
