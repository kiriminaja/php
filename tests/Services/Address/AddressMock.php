<?php

namespace KiriminAja\Services\Address;

use KiriminAja\Repositories\AddressRepository;

class AddressMock
{
    public function addressMock()
    {
        return \Mockery::mock("overload:".AddressRepository::class);
    }
}
