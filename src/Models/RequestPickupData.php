<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class RequestPickupData extends ModelBase
{
    /**
     * Sender's full address.
     *
     * Required. Max 200 characters.
     */
    public string $address;

    /**
     * Sender's phone number, formatted as digits starting with 0.
     *
     * Required. Max 15 characters.
     */
    public string $phone;

    /**
     * Sender's name.
     *
     * Required. Max 50 characters.
     */
    public string $name;

    /**
     * Sender's postal code.
     *
     * Optional. Max 5 characters.
     */
    public string $zipcode;

    /**
     * Sender's sub-district (kecamatan) ID.
     *
     * Required.
     */
    public int $kecamatan_id;

    /**
     * Packages to be picked up. See the official docs for how to build the
     * package list.
     *
     * Required. Minimum 1 package.
     *
     * @var PackageData[]|RequestPickupDataList
     */
    public array | RequestPickupDataList $packages;

    /**
     * Pickup schedule. See the #Pickup Schedules section in the docs.
     *
     * Required.
     */
    public string $schedule;

    /**
     * Calling platform name (optional, e.g. the marketplace name).
     */
    public ?string $platform_name = null;

    /**
     * Sender's latitude. Required when using the Lion Parcel courier.
     */
    public ?float $latitude;

    /**
     * Sender's longitude. Required when using the Lion Parcel courier.
     */
    public ?float $longitude;

    function __construct() {
        $this->packages = new RequestPickupDataList();
    }
}
