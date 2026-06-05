<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\Traits\ApiBase;

class AWBRepository
{
    use ApiBase;

    public function print(array $data): array
    {
        return self::api()->post('api/mitra/v6.1/awb/print', $data);
    }
}
