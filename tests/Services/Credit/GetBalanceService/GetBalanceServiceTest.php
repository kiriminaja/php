<?php

namespace KiriminAja\Services\Credit\GetBalanceService;

require_once __DIR__ . '/../CreditMock.php';

use KiriminAja\Services\Credit\CreditMock;
use KiriminAja\Services\Credit\GetBalanceService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetBalanceServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public static function successfulBalancePayloads(): array
    {
        return [
            'results envelope (live API shape)' => [
                ['status' => true, 'text' => 'Success load credit balance', 'results' => ['balance' => 4000724100]],
                4000724100,
            ],
            'singular result envelope' => [
                ['status' => true, 'text' => 'loaded', 'result' => ['balance' => 125000]],
                125000,
            ],
            'data envelope' => [
                ['status' => true, 'text' => 'loaded', 'method' => 'GET', 'code' => '200', 'data' => ['balance' => 125000]],
                125000,
            ],
            'unwrapped balance' => [
                ['status' => true, 'balance' => 50000],
                50000,
            ],
        ];
    }

    #[DataProvider('successfulBalancePayloads')]
    public function testItNormalizesSuccessfulBalancePayloads(array $payload, int $expected): void
    {
        (new CreditMock())->creditMock()
            ->shouldReceive('balance')
            ->once()
            ->andReturn([true, $payload]);

        $result = (new GetBalanceService())->call();

        self::assertTrue($result->status);
        self::assertIsArray($result->data);
        self::assertSame($expected, $result->data['balance']);
    }

    public function testItRejectsSuccessfulResponsesWithoutBalance(): void
    {
        (new CreditMock())->creditMock()
            ->shouldReceive('balance')
            ->once()
            ->andReturn([true, ['status' => true, 'text' => 'loaded']]);

        $result = (new GetBalanceService())->call();

        self::assertFalse($result->status);
        self::assertSame('Credit balance is missing from the API response', $result->message);
        self::assertNull($result->data);
    }
}
