<?php

namespace KiriminAja\Contracts;

use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\ShippingFullPriceData;
use KiriminAja\Models\ShippingPriceData;

interface ShippingContract {
    public function price(ShippingPriceData $data);
    public function fullShippingPrice(ShippingFullPriceData $data);
    public function schedules();
    public function requestPickup(RequestPickupData $data);
    public function payment(string $paymentID);
    public function cancel(string $awb, string $reason);
    public function tracking(string $orderID);
}
