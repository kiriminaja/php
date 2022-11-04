<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Responses\ServiceResponse;

class TrackingService extends ServiceBase {

    private $orderID;
    private $shippingRepo;

    /**
     * @param $orderID
     */
    public function __construct($orderID) {
        $this->orderID      = $orderID;
        $this->shippingRepo = new ShippingRepository;
    }


    public function call(): ServiceResponse {

        if (is_null($this->orderID)){
            return self::error(null, "Params order_id Can't be blank");
        }

        if (is_numeric($this->orderID)){
            return self::error(null, "Params order_id must be an string");
        }

        try {
            [$status, $data] = $this->shippingRepo->tracking($this->orderID);
            if ($status && $data['status']) {
                return self::success([
                    'status_code' => $data['status_code'],
                    'details'     => $data['details'],
                    'histories'   => $data['histories'],
                ], $data['text']);
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
