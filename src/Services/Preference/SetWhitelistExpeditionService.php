<?php

namespace KiriminAja\Services\Preference;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\PreferenceRepository;
use KiriminAja\Responses\ServiceResponse;

class SetWhitelistExpeditionService extends ServiceBase {

    private $services;
    private $preferenceRepo;

    /**
     * @param $services
     */
    public function __construct($services) {
        $this->services = $services;
        $this->preferenceRepo = new PreferenceRepository;
    }


    public function call(): ServiceResponse {
        if (!is_array($this->services)) return self::error(null, 'parameter must be array');
        try {
            [$status, $data] = $this->preferenceRepo->setWhiteListExpedition($this->services);
            if ($status && $data['status']) {
                return self::success(null, $data['text']);
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