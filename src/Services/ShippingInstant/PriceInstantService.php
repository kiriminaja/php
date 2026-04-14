<?php

namespace KiriminAja\Services\ShippingInstant;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Models\ShippingPriceInstantData;
use KiriminAja\Repositories\ShippingInstantRepository;
use KiriminAja\Responses\ServiceResponse;

class PriceInstantService extends ServiceBase
{
    private ShippingPriceInstantData $data;
    private ShippingInstantRepository $shippingInstantRepository;

    /**
     * @param ShippingPriceInstantData $shippingPriceData
     */
    public function __construct(ShippingPriceInstantData $shippingPriceData)
    {
        $this->data = $shippingPriceData;
        $this->shippingInstantRepository = new ShippingInstantRepository();
    }

    /**
     * @return ServiceResponse
     */
    public function call(): ServiceResponse
    {
        if (
            !isset($this->data->origin) ||
            !isset($this->data->destination) ||
            !is_int($this->data->item_price) ||
            !is_int($this->data->weight) ||
            !is_array($this->data->service)
        ) {
            return self::error(null, "Invalid parameter, please see data inquiry");
        }

        try {
            [$status, $data] = $this->shippingInstantRepository->price($this->data);
            if (!is_array($data)) {
                return self::error(null, 'Unexpected response');
            }
            if ($status && isset($data['status']) && $data['status']) {
                return self::success($data['result'] ?? $data, $data['text'] ?? 'loaded');
            }
            if (isset($data['status']) && !$data['status']) {
                return self::error(null, $data['text'] ?? 'Unknown error');
            }
            return self::error(null, json_encode($data));
        } catch (\Throwable $th) {
            return self::error(null, $th->getMessage());
        }
    }
}
