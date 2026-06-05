<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\Traits\ApiBase;

class ProfileRepository
{
    use ApiBase;

    public function get(): array
    {
        return self::api()->get('api/mitra/v6.2/profile');
    }
}
