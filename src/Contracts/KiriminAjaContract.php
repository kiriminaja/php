<?php

namespace KiriminAja\Contracts;

use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\ShippingFullPriceData;
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Responses\ServiceResponse;

interface KiriminAjaContract {

    /**
     * @param $provinceID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getCity($provinceID): ServiceResponse;

    /**
     * @param $name
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getDistrictByName($name): ServiceResponse;

    public static function getDistrict($cityID): ServiceResponse;

    public static function getProvince(): ServiceResponse;

    public static function setWhiteListExpedition($services): ServiceResponse;

    public static function setCallback($url): ServiceResponse;

    public static function getPrice(ShippingPriceData $data): ServiceResponse;

    public static function fullShippingPrice(ShippingFullPriceData $data): ServiceResponse;

    public static function getSchedules(): ServiceResponse;

    public static function requestPickup(RequestPickupData $data): ServiceResponse;

    public static function getPayment($paymentID): ServiceResponse;

    public static function cancelShipment($awb, $reason): ServiceResponse;

    /**
     * @param $orderID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getTracking($orderID): ServiceResponse;

}
