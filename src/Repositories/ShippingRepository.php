<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\ApiBase;
use KiriminAja\Contracts\ShippingContract;
use KiriminAja\Models\PackageData;
use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\ShippingFullPriceData;
use KiriminAja\Models\ShippingPriceData;

class ShippingRepository implements ShippingContract {

    use ApiBase;

    public function price(ShippingPriceData $data): array {
        return self::api()->post('api/mitra/shipping_price', $data->toArray());
    }

    public function fullShippingPrice(ShippingFullPriceData $data): array {
        return self::api()->post('api/mitra/v5/shipping_price', $data->toArray());
    }

    public function schedules(): array {
        return self::api()->post('api/mitra/v2/schedules', null);
    }

    public function requestPickup(RequestPickupData $data): array {

        if (!is_array($data->packages)) throw new \Exception("Package is not array");

        foreach ($data->packages as $package) {
            if (!($package instanceof PackageData)) {
                throw new \Exception("Package is not type of PackageData");
            }
        }

        $arrayData = $data->toArray();
        return self::api()->post('api/mitra/v2/request_pickup', $arrayData);
    }

    public function payment($paymentID): array {
        return self::api()->post('api/mitra/v2/get_payment', ['payment_id' => $paymentID]);
    }

    public function cancel($awb, $reason): array {
        return self::api()->post('api/mitra/v3/cancel_shipment', [
            "awb"    => $awb,
            "reason" => $reason
        ]);
    }

    public function tracking($orderID): array {
        return self::api()->post('api/mitra/tracking', ['order_id' => $orderID]);
    }
}
