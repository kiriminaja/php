<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Responses\ServiceResponse;

class ScheduleService extends ServiceBase {


    private $shippingRepo;

    public function __construct() {
        $this->shippingRepo = new ShippingRepository;
    }

    public function call(): ServiceResponse {
        try {
            [$status, $data] = $this->shippingRepo->schedules();
            if ($status && $data['status']) {
                return self::success($data['schedules'], "loaded");
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