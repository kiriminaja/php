<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class PackageData extends ModelBase
{
    /**
     * Order ID. Must include a string prefix.
     *
     * Required. Max 20 characters.
     */
    public string $order_id;

    /**
     * Recipient name.
     *
     * Required. Max 50 characters.
     */
    public string $destination_name;

    /**
     * Recipient phone number, formatted as digits starting with 0.
     *
     * Required. Max 15 characters.
     */
    public string $destination_phone;

    /**
     * Recipient address. Minimum 10 characters to avoid Bad Address pickups.
     *
     * Required. 10-200 characters.
     */
    public string $destination_address;

    /**
     * Recipient sub-district (kecamatan) ID.
     *
     * Required.
     */
    public int $destination_kecamatan_id;

    /**
     * Recipient postal code.
     */
    public string|int $destination_zipcode;

    /**
     * Package weight in grams.
     *
     * Required. Minimum 1.
     */
    public int $weight = 1;

    /**
     * Package width in centimetres.
     *
     * Required. Minimum 1.
     */
    public int $width = 1;

    /**
     * Package length in centimetres.
     *
     * Required. Minimum 1.
     */
    public int $length = 1;

    /**
     * Number of items in the package. Defaults to 1 when omitted.
     *
     * Optional.
     */
    public int $qty = 1;

    /**
     * Package height in centimetres.
     *
     * Required. Minimum 1.
     */
    public int $height = 1;

    /**
     * Total declared value of the goods.
     *
     * Required.
     */
    public int $item_value = 0;

    /**
     * Shipping cost. See the # Shipping Price section.
     *
     * Required.
     */
    public int $shipping_cost = 0;

    /**
     * Shipping service code. See the shipping price endpoint for valid values.
     *
     * Required.
     */
    public string $service = '';

    /**
     * Insurance amount. See KiriminAja's Terms & Conditions.
     *
     * Optional.
     */
    public ?int $insurance_amount = 0;

    /**
     * Service type, e.g. EZ, REG, CTC, OKE (see the shipping price section).
     *
     * Required.
     */
    public string $service_type = '';

    /**
     * COD price. Use 0 for non-COD packages.
     *
     * Required.
     */
    public int $cod = 0;

    /**
     * Package type ID. Currently only `1` is supported.
     *
     * Required.
     */
    public int $package_type_id = 1;

    /**
     * Package contents description.
     *
     * Required. Max 255 characters.
     */
    public string $item_name = '';

    /**
     * Drop-off / cashless flag.
     *
     * Optional.
     */
    public ?bool $drop = false;

    /**
     * Special instructions for the courier.
     *
     * Optional. Max 50 characters.
     */
    public string $note = '';

    /**
     * Optional list of items contained in this package. When provided each
     * element must be an instance of PackageItemData. The `item_value`
     * property is still required.
     *
     * @var PackageItemData[]|null
     */
    public ?array $items = null;

    public function toArray(): array
    {
        $data = parent::toArray();
        if (is_null($this->items)) {
            unset($data['items']);
            return $data;
        }
        $data['items'] = array_map(
            static fn (PackageItemData $item) => $item->toArray(),
            $this->items,
        );
        return $data;
    }
}
