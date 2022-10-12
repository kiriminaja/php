<?php

namespace KiriminAja\Services\Address;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Responses\ServiceResponse;
use KiriminAja\Utils\Validator;

class CityService extends ServiceBase {
    private $addressRepository;
    private $provinceID;

    /**
     * @param $provinceID
     */
    public function __construct($provinceID) {
        $this->addressRepository = new AddressRepository;
        $this->provinceID        = $provinceID;
    }

    /**
     * @return \Rakit\Validation\Validation
     */
    private function validation(): \Rakit\Validation\Validation {
        return Validator::make(['province_id' => $this->provinceID], [
            'province_id' => 'required|integer'
        ]);
    }

    /**
     * Main caller
     *
     * @return ServiceResponse
     */
    public function call(): ServiceResponse {
        if ($this->validation()->fails()) return self::error(null, $this->validation()->errors()->first());
        try {
            [$status, $data] = $this->addressRepository->cities($this->provinceID);
            if ($status) {
                return self::success($data, "loaded");
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