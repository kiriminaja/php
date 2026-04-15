<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class ShippingPriceInstantData extends ModelBase
{
    /**
     * @var array $service List of instant service codes e.g. ['grab_express', 'gosend']
     */
    public array $service = [];

    /**
     * @var int $item_price
     */
    public int $item_price;

    /**
     * @var array $origin Origin location with keys: lat, long, address
     */
    public array $origin;

    /**
     * @var array $destination Destination location with keys: lat, long, address
     */
    public array $destination;

    /**
     * @var int $weight Weight in grams
     */
    public int $weight;

    /**
     * @var string $vehicle Vehicle type: 'motor' or 'mobil'
     */
    public string $vehicle = "motor";

    /**
     * @var string $timezone Timezone e.g. 'Asia/Jakarta'
     */
    public string $timezone = "Asia/Jakarta";
}
