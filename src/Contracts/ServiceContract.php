<?php

namespace KiriminAja\Contracts;

use KiriminAja\Responses\ServiceResponse;

interface ServiceContract {
    public function call(): ServiceResponse;
}