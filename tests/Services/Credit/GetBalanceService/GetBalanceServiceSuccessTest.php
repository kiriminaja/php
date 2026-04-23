<?php

namespace KiriminAja\Services\Credit\GetBalanceService;

require_once(__DIR__ . '/../CreditMock.php');

use KiriminAja\Services\Credit\CreditMock;
use KiriminAja\Services\Credit\GetBalanceService;
use PHPUnit\Framework\TestCase;

class GetBalanceServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new CreditMock)->creditMock()
            ->shouldReceive([
                'balance' => [
                    true,
                    [
                        'status' => true,
                        'text'   => 'loaded',
                        'method' => 'GET',
                        'code'   => '200',
                        'data'   => [
                            'balance' => 125000,
                        ],
                    ],
                ],
            ]);
    }

    public function test()
    {
        $result = (new GetBalanceService())->call();

        self::assertTrue($result->status);
        self::assertEquals('loaded', $result->message);
        self::assertIsArray($result->data);
        self::assertEquals(125000, $result->data['balance']);
    }
}
