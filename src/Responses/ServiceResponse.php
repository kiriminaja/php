<?php

namespace KiriminAja\Responses;

use KiriminAja\Base\ModelBase;

class ServiceResponse extends ModelBase {
    public $status = false;
    public $message = "-";
    public $data;

    /**
     * @param bool $status
     * @param string $message
     * @param $data
     */
    public function __construct(bool $status, string $message, $data) {
        $this->status  = $status;
        $this->message = $message;
        $this->data    = $data;
    }

}