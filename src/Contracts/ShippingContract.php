<?php

namespace KiriminAja\Contracts;

use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\ShippingPriceData;

interface ShippingContract {
    public function price(ShippingPriceData $data);
    public function schedules();
    public function requestPickup(RequestPickupData $data);
    public function payment($paymentID);
    public function cancel($awb, $reason);
    public function tracking($orderID);
}