<?php

namespace KiriminAja\Base\Api;

use GuzzleHttp\Client;
use KiriminAja\Contracts\ServiceClientContract;

class Api implements ServiceClientContract {

    use ApiOptions;

    /**
     * @param bool $useInstant
     */
    public function __construct(bool $useInstant = false)
    {
        $this->setUseInstant($useInstant);
    }

    /**
     * @param string $endPoint
     * @param $data
     * @return array
     */
    public function get(string $endPoint, $data = null): array {
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
     * POST request with query parameters (no JSON body).
     *
     * @param string $endPoint
     * @param array|null $query
     * @return array
     */
    public function postWithQuery(string $endPoint, ?array $query = null): array {
        return $this->requestWithQuery('POST', $endPoint, $query);
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
    public function delete(string $endPoint, $data = null): array {
        return $this->request('DELETE', $endPoint, $data);
    }
}
