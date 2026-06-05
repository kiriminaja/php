<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\Traits\ApiBase;

class CalculationsRepository
{
    use ApiBase;

    public function cod(array $data): array
    {
        return self::api()->post('api/mitra/calculations/cod', $data);
    }
}
