<?php

namespace KiriminAja\Base\Api;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Base\Config\KiriminAjaConfig;

trait ApiOptions
{

    private $method;
    private bool $useInstant = false;

    /**
     * @return bool
     */
    public function isUseInstant(): bool
    {
        return $this->useInstant;
    }

    /**
     * @param bool $useInstant
     */
    public function setUseInstant(bool $useInstant): void
    {
        $this->useInstant = $useInstant;
    }

    /**
     * Getter base url
     *
     * @return string
     * @throws Exception
     */
    private static function baseURL(): string
    {
        switch (KiriminAjaConfig::mode()->getMode()) {
            case Mode::Staging:
                return "https://tdev.kiriminaja.com/";
            case Mode::Production :
                return "https://kiriminaja.com/";
            default :
                throw new Exception("unknown mode");
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    private static function baseURLInstant(): string
    {
        switch (KiriminAjaConfig::mode()->getMode()) {
            case Mode::Staging:
                return "https://apieks-staging.kiriminaja.com/";
            case Mode::Production :
                return "https://api.kiriminaja.com/";
            default :
                throw new Exception("Unknown mode");
        }
    }

    /**
     * Getter headers
     *
     * @return string[]
     */
    protected static function getHeaders(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => "Bearer " . KiriminAjaConfig::apiKey()->getKey(),
        ];
    }

    /**
     * Data option
     *
     * @param $data
     * @return array
     */
    protected function dataOption($data): array
    {
        switch (strtoupper($this->method)) {
            case "GET" :
                return [
                    "headers" => self::getHeaders(),
                    "query" => $data
                ];
            case "POST" :
            default:
                return [
                    "headers" => self::getHeaders(),
                    "json" => $data
                ];
        }
    }

    /**
     * URL to consume client
     *
     * @param $endpoint
     * @return string
     * @throws Exception
     */
    protected static function url($endpoint): string
    {
        return ((new Api)->isUseInstant() ? self::baseURLInstant() : self::baseURL()) . $endpoint;
    }

    /**
     * Getter client
     *
     * @return Client
     */
    protected static function client(): Client
    {
        return new Client;
    }

    /**
     * Request to client
     *
     * @param $method
     * @param $endpoint
     * @param $data
     * @return array
     */
    protected function request($method, $endpoint, $data): array
    {
        $this->method = $method;
        try {
            $request = self::client()->request($this->method, self::url($endpoint), $this->dataOption($data));
            return [true, json_decode($request->getBody()->getContents(), true)];
        } catch (\Throwable|GuzzleException $e) {
            return [false, $e->getMessage()];
        }
    }
}
