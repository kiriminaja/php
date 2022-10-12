<?php

namespace KiriminAja\Services;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Contracts\KiriminAjaContract;
use KiriminAja\Contracts\ServiceContract;
use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Responses\ServiceResponse;
use KiriminAja\Services\Address\CityService;
use KiriminAja\Services\Address\DistrictByNameService;
use KiriminAja\Services\Address\DistrictService;
use KiriminAja\Services\Address\ProvinceService;
use KiriminAja\Services\Preference\SetCallbackService;
use KiriminAja\Services\Preference\SetWhitelistExpeditionService;
use KiriminAja\Services\Shipping\CancelShippingService;
use KiriminAja\Services\Shipping\GetPaymentService;
use KiriminAja\Services\Shipping\PriceService;
use KiriminAja\Services\Shipping\RequestPickupService;
use KiriminAja\Services\Shipping\ScheduleService;
use KiriminAja\Services\Shipping\TrackingService;

class KiriminAja implements KiriminAjaContract {

    /**
     * Call service when called
     * @param ServiceContract $service
     * @return ServiceResponse
     */
    private static function call(ServiceContract $service): ServiceResponse {
        return $service->call();
    }

    public static function getCity($provinceID): ServiceResponse {
        return self::call((new CityService($provinceID)));
    }

    public static function getDistrictByName($name): ServiceResponse {
        return self::call((new DistrictByNameService($name)));
    }

    public static function getDistrict($cityID): ServiceResponse {
        return self::call((new DistrictService($cityID)));
    }

    public static function getProvince(): ServiceResponse {
        return self::call((new ProvinceService()));
    }

    public static function setWhiteListExpedition($services): ServiceResponse {
        return self::call((new SetWhitelistExpeditionService($services)));
    }

    public static function setCallback($url): ServiceResponse {
        return self::call((new SetCallbackService($url)));
    }

    public static function getPrice(ShippingPriceData $data): ServiceResponse {
        return self::call((new PriceService($data)));
    }

    public static function getSchedules(): ServiceResponse {
        return self::call((new ScheduleService()));
    }

    public static function requestPickup(RequestPickupData $data): ServiceResponse {
        return self::call((new RequestPickupService($data)));
    }

    public static function getPayment($paymentID): ServiceResponse {
        return self::call((new GetPaymentService($paymentID)));
    }

    public static function cancelShipment($awb, $reason): ServiceResponse {
        return self::call((new CancelShippingService($awb, $reason)));
    }

    public static function getTracking($orderID): ServiceResponse {
        return self::call((new TrackingService($orderID)));
    }
}