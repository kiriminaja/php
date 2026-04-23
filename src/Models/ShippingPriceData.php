<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class ShippingPriceData extends ModelBase {
    /**
     * Sender's sub-district (kecamatan) ID.
     *
     * Required.
     */
    public int $origin;

    /**
     * Recipient's sub-district (kecamatan) ID.
     *
     * Required.
     */
    public int $destination;

    /**
     * Total package weight in grams (actual weight). When the volumetric
     * weight is greater than the actual weight, the volumetric weight is
     * used instead.
     *
     * Required.
     */
    public int $weight;

    /**
     * Whether the package needs insurance (1 = true, 0 = false).
     *
     * Optional.
     */
    public ?int $insurance = null;

    /**
     * Required when `insurance` is set. May also be supplied to compute the
     * COD fee for COD packages.
     *
     * Optional.
     */
    public ?int $item_value = null;

    /**
     * Single courier code or list of courier codes. Contact us for the full
     * list of available couriers.
     *
     * Optional.
     *
     * @var string|string[]|null
     */
    public $courier;

    /**
     * Package width in centimetres.
     */
    public int $width = 0;

    /**
     * Package length in centimetres.
     */
    public int $length = 0;

    /**
     * Package height in centimetres.
     */
    public int $height = 0;
}
