<?php

namespace KiriminAja\Contracts;

use KiriminAja\Responses\ServiceResponse;

interface ResponseContract {
    public static function success($data, $message): ServiceResponse;

    public static function error($data, $message): ServiceResponse;
}
