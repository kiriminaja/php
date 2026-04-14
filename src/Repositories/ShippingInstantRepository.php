<?php

namespace KiriminAja\Repositories;

use KiriminAja\Base\Traits\ApiBase;
use KiriminAja\Contracts\ShippingInstantContract;
use KiriminAja\Models\RequestPickupInstantData;
use KiriminAja\Models\ShippingPriceInstantData;

class ShippingInstantRepository implements ShippingInstantContract
{
    use ApiBase;

    /**
     * @param ShippingPriceInstantData $shippingPriceInstantData
     * @return array
     */
    public function price(ShippingPriceInstantData $shippingPriceInstantData): array
    {
        return self::api()->post('api/mitra/v4/instant/pricing', $shippingPriceInstantData->toArray());
    }

    /**
     * @param string $orderId
     * @return array
     */
    public function findNewDriver(string $orderId): array
    {
        return self::api()->post('api/mitra/v4/instant/pickup/find-new-driver', [
            "order_id" => $orderId
        ]);
    }

    /**
     * @param string $paymentId
     * @return array
     */
    public function getPayment(string $paymentId): array
    {
        return self::api()->post('api/mitra/v2/get_payment', ['payment_id' => $paymentId]);
    }

    /**
     * @param RequestPickupInstantData $requestPickupInstantData
     * @return array
     */
    public function create(RequestPickupInstantData $requestPickupInstantData): array
    {
        return self::api()->post('api/mitra/v4/instant/pickup/request', $requestPickupInstantData->getMapped());
    }

    /**
     * @param string $orderId
     * @return array
     */
    public function cancel(string $orderId): array
    {
        return self::api()->delete("api/mitra/v4/instant/pickup/void/{$orderId}");
    }

    /**
     * @param string $orderId
     * @return array
     */
    public function tracking(string $orderId): array
    {
        return self::api()->get("api/mitra/v4/instant/tracking/{$orderId}");
    }
}
