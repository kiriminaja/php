<?php

namespace KiriminAja\Services\Address;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Responses\ServiceResponse;

class DistrictByNameService extends ServiceBase {
    private $addressRepository;
    private $name;

    /**
     * @param $name
     */
    public function __construct($name) {
        $this->addressRepository = new AddressRepository;
        $this->name              = $name;
    }

    public function call(): ServiceResponse {
        try {
            [$status, $data] = $this->addressRepository->districtsByName($this->name);
            if ($status && $data['status']) {
                return self::success($data['data'], "loaded");
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
