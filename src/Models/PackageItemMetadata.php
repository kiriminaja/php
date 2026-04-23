<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class PackageItemMetadata extends ModelBase
{
    public ?string $sku = null;
    public ?string $variant_label = null;

    public function toArray(): array
    {
        $data = [];
        if (!is_null($this->sku)) {
            $data['sku'] = $this->sku;
        }
        if (!is_null($this->variant_label)) {
            $data['variant_label'] = $this->variant_label;
        }
        return $data;
    }
}
