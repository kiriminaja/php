<?php

namespace KiriminAja\Services\Courier;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\CourierRepository;
use KiriminAja\Responses\ServiceResponse;

class CourierGroupService extends ServiceBase
{
    private CourierRepository $courierRepo;

    public function __construct()
    {
        $this->courierRepo = new CourierRepository;
    }

    /**
     * @return ServiceResponse
     */
    public function call(): ServiceResponse
    {
        try {
            [$status, $data] = $this->courierRepo->group();
            if ($status && $data['status']) {
                return self::success($data['datas'], $data['text']);
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
