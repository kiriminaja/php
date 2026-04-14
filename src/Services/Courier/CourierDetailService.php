<?php

namespace KiriminAja\Services\Courier;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\CourierRepository;
use KiriminAja\Responses\ServiceResponse;

class CourierDetailService extends ServiceBase
{
    private CourierRepository $courierRepo;
    private string $courierCode;

    /**
     * @param string $courierCode
     */
    public function __construct(string $courierCode)
    {
        $this->courierCode = $courierCode;
        $this->courierRepo = new CourierRepository;
    }

    /**
     * @return ServiceResponse
     */
    public function call(): ServiceResponse
    {
        try {
            [$status, $data] = $this->courierRepo->detail($this->courierCode);
            if (!is_array($data)) {
                return self::error(null, 'Unexpected response');
            }
            if ($status && isset($data['status']) && $data['status']) {
                return self::success($data['datas'] ?? [], $data['text'] ?? 'loaded');
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
