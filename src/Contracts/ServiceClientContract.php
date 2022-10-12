<?php

namespace KiriminAja\Contracts;

use GuzzleHttp\Client;

interface ServiceClientContract {
    public function get(string $endPoint, $data);

    public function post(string $endPoint, $data);

    public function put(string $endPoint, $data);

    public function delete(string $endPoint, $data);
}