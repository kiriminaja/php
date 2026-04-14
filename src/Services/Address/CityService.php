<?php

namespace KiriminAja\Services\Address;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Responses\ServiceResponse;
use KiriminAja\Utils\ValidationResult;
use KiriminAja\Utils\Validator;

class CityService extends ServiceBase
{
    private AddressRepository $addressRepository;
    private int               $provinceID;

    /**
     * @param int $provinceID
     */
    public function __construct(int $provinceID)
    {
        $this->addressRepository = new AddressRepository;
        $this->provinceID        = $provinceID;
    }

    /**
     * @return ValidationResult
     */
    private function validation(): ValidationResult
    {
        return Validator::validate([
            'province_id' => $this->provinceID
        ], [
            'province_id' => 'required|numeric'
        ]);
    }

    /**
     * Main caller
     *
     * @return ServiceResponse
     */
    public function call(): ServiceResponse
    {
        // Validate province_id
        if ($this->validation()->fails()) return self::error(null, $this->validation()->errors()[0]);

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
            return self::error(null, $th->getMessage() . ' line ' . $th->getLine());
        }
    }
}
