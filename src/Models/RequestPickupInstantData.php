<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;
use KiriminAja\Contracts\WithMappedData;

class RequestPickupInstantData extends ModelBase implements WithMappedData
{
    public string $service;
    public string $service_type;
    public string $vehicle;
    public string $order_prefix;
    public array $packages = [];

    /**
     * @return array
     */
    public function getMapped(): array
    {
        return $this->toArray();
    }
}
