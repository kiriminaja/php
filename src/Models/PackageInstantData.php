<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;
use KiriminAja\Contracts\WithMappedData;

class PackageInstantData extends ModelBase implements WithMappedData
{
    public string $origin_name;
    public string $origin_phone;
    public float $origin_lat;
    public float $origin_long;
    public string $origin_address;
    public string $origin_address_note;
    public string $destination_name;
    public string $destination_phone;
    public float $destination_lat;
    public float $destination_long;
    public string $destination_address;
    public string $destination_address_note;
    public int $shipping_price;
    public string $item_name;
    public string $item_description;
    public int $item_price;
    public int $item_weight;

    /**
     * @return array
     */
    public function getMapped(): array
    {
        $data = $this->toArray();
        $data['item'] = [
            'name' => $this->item_name,
            'description' => $this->item_description,
            'price' => $this->item_price,
            'weight' => $this->item_weight,
        ];
        unset($data['item_name']);
        unset($data['item_description']);
        unset($data['item_price']);
        unset($data['item_weight']);
        return $data;
    }
}
