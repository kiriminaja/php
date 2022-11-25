<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Responses\ServiceResponse;

class GetPaymentService extends ServiceBase {

    private $paymentID;
    private $shippingRepo;

    /**
     * @param $paymentID
     */
    public function __construct($paymentID) {
        $this->paymentID    = $paymentID;
        $this->shippingRepo = new ShippingRepository;
    }


    public function call(): ServiceResponse {
        if (is_numeric($this->paymentID)) {
            return self::error(null, "payment_id Params must be an string");
        }

        if (is_null($this->paymentID)) {
            return self::error(null, "payment_id Params Can't be blank");
        }

        try {
            [$status, $data] = $this->shippingRepo->payment($this->paymentID);
            if ($status && $data['status']) {
                return self::success($data['data'], $data['text']);
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text']);
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }
}
