<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class ShippingFullPriceData extends ModelBase {
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
}
