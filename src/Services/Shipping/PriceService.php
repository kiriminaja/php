<?php

namespace KiriminAja\Services\Shipping;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Responses\ServiceResponse;

class PriceService extends ServiceBase {

    private $data;
    private $shippingRepo;

    /**
     * @param ShippingPriceData $data
     */
    public function __construct(ShippingPriceData $data) {
        $this->data         = $data;
        $this->shippingRepo = new ShippingRepository;
    }


    public function call(): ServiceResponse {
        try {
            [$status, $data] = $this->shippingRepo->price($this->data);
            if ($status && $data['status']) {
                return self::success(['details' => $data['details'], 'results' => $data['results'],], "loaded");
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