<?php

namespace KiriminAja\Services;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Contracts\KiriminAjaContract;
use KiriminAja\Contracts\ServiceContract;
use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\ShippingFullPriceData;
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Responses\ServiceResponse;
use KiriminAja\Services\Address\CityService;
use KiriminAja\Services\Address\DistrictByNameService;
use KiriminAja\Services\Address\DistrictService;
use KiriminAja\Services\Address\ProvinceService;
use KiriminAja\Services\Preference\SetCallbackService;
use KiriminAja\Services\Preference\SetWhitelistExpeditionService;
use KiriminAja\Services\Shipping\CancelShippingService;
use KiriminAja\Services\Shipping\FullShippingPrice;
use KiriminAja\Services\Shipping\GetPaymentService;
use KiriminAja\Services\Shipping\PriceService;
use KiriminAja\Services\Shipping\RequestPickupService;
use KiriminAja\Services\Shipping\ScheduleService;
use KiriminAja\Services\Shipping\TrackingService;

class KiriminAja implements KiriminAjaContract
{

    /**
     * Call service when called
     * @param ServiceContract $service
     * @return ServiceResponse
     */
    private static function call(ServiceContract $service): ServiceResponse
    {
        return $service->call();
    }

    /**
     * @param int $provinceID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getCity(int $provinceID): ServiceResponse
    {
        return self::call((new CityService($provinceID)));
    }

    /**
     * @param string $name
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getDistrictByName(string $name): ServiceResponse
    {
        return self::call((new DistrictByNameService($name)));
    }

    /**
     * @param int $cityID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getDistrict(int $cityID): ServiceResponse
    {
        return self::call((new DistrictService($cityID)));
    }

    /**
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getProvince(): ServiceResponse
    {
        return self::call((new ProvinceService()));
    }

    /**
     * @param array $services
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function setWhiteListExpedition(array $services): ServiceResponse
    {
        return self::call((new SetWhitelistExpeditionService($services)));
    }

    /**
     * @param string $url
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function setCallback(string $url): ServiceResponse
    {
        return self::call((new SetCallbackService($url)));
    }

    /**
     * @param \KiriminAja\Models\ShippingPriceData $data
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getPrice(ShippingPriceData $data): ServiceResponse
    {
        return self::call((new PriceService($data)));
    }

    /**
     * @param \KiriminAja\Models\ShippingFullPriceData $data
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function fullShippingPrice(ShippingFullPriceData $data): ServiceResponse
    {
        return self::call((new FullShippingPrice($data)));
    }

    /**
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getSchedules(): ServiceResponse
    {
        return self::call((new ScheduleService()));
    }

    /**
     * @param \KiriminAja\Models\RequestPickupData $data
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function requestPickup(RequestPickupData $data): ServiceResponse
    {
        return self::call((new RequestPickupService($data)));
    }

    /**
     * @param string $paymentID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getPayment(string $paymentID): ServiceResponse
    {
        return self::call((new GetPaymentService($paymentID)));
    }

    /**
     * @param string $awb
     * @param string $reason
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function cancelShipment(string $awb, string $reason): ServiceResponse
    {
        return self::call((new CancelShippingService($awb, $reason)));
    }

    /**
     * @param string $orderID
     * @return \KiriminAja\Responses\ServiceResponse
     */
    public static function getTracking(string $orderID): ServiceResponse
    {
        return self::call((new TrackingService($orderID)));
    }
}
