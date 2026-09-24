<?php

namespace Tests\Base\Api;

use KiriminAja\Base\Api\Api;
use KiriminAja\Base\Config\KiriminAjaConfig;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiTest extends TestCase
{
    protected function setUp(): void
    {
        KiriminAjaConfig::setCacheDirectory(sys_get_temp_dir() . '/kiriminaja-phpunit-api-cache');
        KiriminAjaConfig::setBaseUrl('https://api.example.test');
        KiriminAjaConfig::setApiTokenKey('test-token');
    }

    public function testGetSendsQueryAndHeaders(): void
    {
        $client = new RecordingClient(new Response(200, [], '{"status":true}'));

        $result = (new Api($client))->get('cities', ['province_id' => 12]);

        $this->assertSame([true, ['status' => true]], $result);
        $this->assertSame('GET', $client->request->getMethod());
        $this->assertSame('https://api.example.test/cities?province_id=12', (string) $client->request->getUri());
        $this->assertSame('Bearer test-token', $client->request->getHeaderLine('Authorization'));
        $this->assertSame('', (string) $client->request->getBody());
    }

    public function testPostSendsJsonBody(): void
    {
        $client = new RecordingClient(new Response(200, [], '{"status":true}'));

        (new Api($client))->post('shipments', ['reference_no' => 'ORDER-1']);

        $this->assertSame('POST', $client->request->getMethod());
        $this->assertSame('application/json', $client->request->getHeaderLine('Content-Type'));
        $this->assertSame('{"reference_no":"ORDER-1"}', (string) $client->request->getBody());
    }

    public function testPostWithQueryDoesNotSendBody(): void
    {
        $client = new RecordingClient(new Response(200, [], '{"status":true}'));

        (new Api($client))->postWithQuery('cancel', ['awb' => 'ABC 123']);

        $this->assertSame('https://api.example.test/cancel?awb=ABC%20123', (string) $client->request->getUri());
        $this->assertSame('', (string) $client->request->getBody());
    }

    public function testHttpErrorReturnsFailure(): void
    {
        $client = new RecordingClient(new Response(422, [], '{"status":false}'));

        $this->assertSame(
            [false, 'HTTP request failed with status code 422'],
            (new Api($client))->post('shipments', [])
        );
    }

    public function testClientExceptionReturnsFailure(): void
    {
        $client = new class implements ClientInterface {
            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                throw new \RuntimeException('Connection failed');
            }
        };

        $this->assertSame(
            [false, 'Connection failed'],
            (new Api($client))->get('cities')
        );
    }
}

class RecordingClient implements ClientInterface
{
    public RequestInterface $request;

    public function __construct(private ResponseInterface $response)
    {
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->request = $request;

        return $this->response;
    }
}
