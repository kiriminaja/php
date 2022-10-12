<?php

namespace KiriminAja\Services\Preference;

use KiriminAja\Base\ServiceBase;
use KiriminAja\Repositories\PreferenceRepository;
use KiriminAja\Responses\ServiceResponse;

class SetCallbackService extends ServiceBase {

    private $url;
    private $preferenceRepo;

    /**
     * @param $url
     */
    public function __construct($url) {
        $this->url = $url;
        $this->preferenceRepo = new PreferenceRepository;
    }

    public function call(): ServiceResponse {
        try {
            [$status, $data] = $this->preferenceRepo->setCallback($this->url);
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