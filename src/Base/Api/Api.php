<?php

namespace KiriminAja\Base\Api;

use GuzzleHttp\Client;
use KiriminAja\Contracts\ServiceClientContract;

class Api implements ServiceClientContract {

    use ApiOptions;

    /**
     * @param string $endPoint
     * @param $data
     * @return array
     */
    public function get(string $endPoint, $data): array {
        return $this->request('GET', $endPoint, $data);
    }

    /**
     * @param string $endPoint
     * @param $data
     * @return array
     */
    public function post(string $endPoint, $data): array {
        return $this->request('POST', $endPoint, $data);
    }

    /**
     * @param string $endPoint
     * @param $data
     * @return array
     */
    public function put(string $endPoint, $data): array {
        return $this->request('PUT', $endPoint, $data);
    }

    /**
     * @param string $endPoint
     * @param $data
     * @return array
     */
    public function delete(string $endPoint, $data): array {
        return $this->request('DELETE', $endPoint, $data);
    }
}
