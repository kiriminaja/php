<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class PackageItemData extends ModelBase
{
    public string $name = '';
    public int $price = 0;
    public int $qty = 0;
    public int $weight = 0;
    public ?int $width = null;
    public ?int $length = null;
    public ?int $height = null;
    public ?PackageItemMetadata $metadata = null;

    public function toArray(): array
    {
        $data = [
            'name'   => $this->name,
            'price'  => $this->price,
            'qty'    => $this->qty,
            'weight' => $this->weight,
        ];
        if (!is_null($this->width)) {
            $data['width'] = $this->width;
        }
        if (!is_null($this->length)) {
            $data['length'] = $this->length;
        }
        if (!is_null($this->height)) {
            $data['height'] = $this->height;
        }
        if (!is_null($this->metadata)) {
            $data['metadata'] = $this->metadata->toArray();
        }
        return $data;
    }
}
