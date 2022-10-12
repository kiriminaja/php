<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Responses\ServiceResponse;

class CancelShippingService extends ServiceBase {

    private $awb, $reason, $shippingRepo;

    /**
     * @param $awb
     * @param $reason
     */
    public function __construct($awb, $reason) {
        $this->awb          = $awb;
        $this->reason       = $reason;
        $this->shippingRepo = new ShippingRepository;
    }


    public function call(): ServiceResponse {
        try {
            [$status, $data] = $this->shippingRepo->cancel($this->awb, $this->reason);
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