<?php

namespace KiriminAja\Base;

use KiriminAja\Base\Api\Api;

trait ApiBase {

    /**
     * Getter Api client
     *
     * @return Api
     */
    protected static function api(): Api {
        return new Api;
    }

}