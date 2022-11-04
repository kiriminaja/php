<?php

namespace KiriminAja\Services\Address;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Responses\ServiceResponse;
use KiriminAja\Utils\Validator;

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

        if(is_null($this->name)){
            return self::error(null, "Params name Can't be blank");
        }

        if(is_numeric($this->name)){
            return self::error(null, 'Params name must be an string');
        }

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
