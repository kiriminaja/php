<?php

namespace KiriminAja\Contracts;

use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\ShippingFullPriceData;
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Responses\ServiceResponse;

interface KiriminAjaContract {

    /**
     * @param int $provinceID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getCity(int $provinceID): ServiceResponse;

    /**
     * @param string $name
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getDistrictByName(string $name): ServiceResponse;

    /**
     * @param int $cityID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getDistrict(int $cityID): ServiceResponse;

    /**
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getProvince(): ServiceResponse;

    /**
     * @param array $services
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function setWhiteListExpedition(array $services): ServiceResponse;

    /**
     * @param $url
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function setCallback(string $url): ServiceResponse;

    /**
     * @param \KiriminAja\Models\ShippingPriceData $data
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getPrice(ShippingPriceData $data): ServiceResponse;

    /**
     * @param \KiriminAja\Models\ShippingFullPriceData $data
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function fullShippingPrice(ShippingFullPriceData $data): ServiceResponse;

    /**
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getSchedules(): ServiceResponse;

    /**
     * @param \KiriminAja\Models\RequestPickupData $data
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function requestPickup(RequestPickupData $data): ServiceResponse;

    /**
     * @param string $paymentID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getPayment(string $paymentID): ServiceResponse;

    /**
     * @param string $awb
     * @param string $reason
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function cancelShipment(string $awb, string $reason): ServiceResponse;

    /**
     * @param string $orderID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getTracking(string $orderID): ServiceResponse;

}
