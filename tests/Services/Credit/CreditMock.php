<?php

namespace KiriminAja\Services\Credit;

use KiriminAja\Repositories\CreditRepository;

class CreditMock
{
    public function creditMock()
    {
        return \Mockery::mock("overload:" . CreditRepository::class);
    }
}
