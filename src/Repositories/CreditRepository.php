<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\Traits\ApiBase;
use KiriminAja\Contracts\CreditContract;

class CreditRepository implements CreditContract
{
    use ApiBase;

    /**
     * Fetch the current KiriminAja credit balance.
     *
     * @return array
     */
    public function balance(): array
    {
        return self::api()->get('api/mitra/v6.2/credit/balance');
    }
}
