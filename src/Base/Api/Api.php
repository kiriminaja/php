<?php

namespace KiriminAja\Base\Api;

use GuzzleHttp\Client;
use KiriminAja\Contracts\ServiceClientContract;

class Api implements ServiceClientContract {

    use ApiOptions;

    public function get(string $endPoint, $data): array {
        return $this->request('GET', $endPoint, $data);
    }

    public function post(string $endPoint, $data): array {
        return $this->request('POST', $endPoint, $data);
    }

    public function put(string $endPoint, $data): array {
        return $this->request('PUT', $endPoint, $data);
    }

    public function delete(string $endPoint, $data): array {
        return $this->request('DELETE', $endPoint, $data);
    }
}