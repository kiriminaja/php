<?php

namespace KiriminAja\Base\Api;

use Exception;
use Http\Client\Curl\Client;
use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Base\Config\KiriminAjaConfig;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

trait ApiOptions
{
    /**
     * Getter base url
     *
     * @return string
     * @throws Exception
     */
    private static function baseURL(): string
    {
        $customBaseUrl = KiriminAjaConfig::baseUrl()->getBaseUrl();
        if ($customBaseUrl) {
            return rtrim($customBaseUrl, '/') . '/';
        }

        return match (KiriminAjaConfig::mode()->getMode()) {
            Mode::Staging => "https://tdev.kiriminaja.com/",
            Mode::Production => "https://client.kiriminaja.com/",
            default => throw new Exception("unknown mode"),
        };
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
     * URL to consume client
     *
     * @param $endpoint
     * @return string
     * @throws Exception
     */
    protected function url($endpoint): string
    {
        return self::baseURL() . $endpoint;
    }

    /**
     * Getter client
     *
     * @return ClientInterface
     */
    protected function client(): ClientInterface
    {
        if ($this->httpClient === null) {
            $factory = new Psr17Factory();
            $this->httpClient = new Client($factory, $factory);
        }

        return $this->httpClient;
    }

    protected function createRequest(string $method, string $endpoint, mixed $data, bool $queryOnly = false): RequestInterface
    {
        $method = strtoupper($method);
        $url = $this->url($endpoint);

        if (($method === 'GET' || $queryOnly) && !empty($data)) {
            $separator = str_contains($url, '?') ? '&' : '?';
            $url .= $separator . http_build_query($data, '', '&', PHP_QUERY_RFC3986);
        }

        $factory = new Psr17Factory();
        $request = $factory->createRequest($method, $url);

        foreach (self::getHeaders() as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($method !== 'GET' && !$queryOnly && $data !== null) {
            $body = json_encode($data, JSON_THROW_ON_ERROR);
            $request = $request->withBody($factory->createStream($body));
        }

        return $request;
    }

    protected function send(RequestInterface $request): array
    {
        $response = $this->client()->sendRequest($request);

        if ($response->getStatusCode() >= 400) {
            return [false, "HTTP request failed with status code {$response->getStatusCode()}"];
        }

        return [true, json_decode((string) $response->getBody(), true)];
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
        try {
            return $this->send($this->createRequest($method, $endpoint, $data));
        } catch (\Throwable $e) {
            return [false, $e->getMessage()];
        }
    }

    /**
     * Request with query parameters (no body).
     *
     * @param string $method
     * @param string $endpoint
     * @param array|null $query
     * @return array
     */
    protected function requestWithQuery(string $method, string $endpoint, ?array $query = null): array
    {
        try {
            return $this->send($this->createRequest($method, $endpoint, $query, true));
        } catch (\Throwable $e) {
            return [false, $e->getMessage()];
        }
    }
}
