<?php

namespace KiriminAja\Services\Address;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Responses\ServiceResponse;

class SubDistrictService extends ServiceBase
{
    private AddressRepository $addressRepository;
    private int $districtId;

    /**
     * @param int $districtId
     */
    public function __construct(int $districtId)
    {
        $this->addressRepository = new AddressRepository;
        $this->districtId = $districtId;
    }

    /**
     * @return ServiceResponse
     */
    public function call(): ServiceResponse
    {
        try {
            [$status, $data] = $this->addressRepository->subDistricts($this->districtId);
            if (!is_array($data)) {
                return self::error(null, 'Unexpected response');
            }
            if ($status && isset($data['status']) && $data['status']) {
                return self::success($data['results'] ?? $data['datas'] ?? [], $data['text'] ?? 'loaded');
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
