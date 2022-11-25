<?php

namespace KiriminAja\Unit\Preference\SetWhitelistExpeditionService;

require_once(__DIR__.'/../PreferenceMock.php');

use KiriminAja\Services\Preference\SetWhitelistExpeditionService;
use KiriminAja\Unit\Preference\PreferenceMock;
use PHPUnit\Framework\TestCase;
use Mockery;

class SetWhitelistExpeditionServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testIsNotArray()
    {
        (new PreferenceMock())->preferenceMock()
            ->shouldReceive([
                'setWhiteListExpedition' => [
                    false,
                    [
                        'status' => false,
                        'message'   => "Parameter must be array",
                        'data' => null
                    ]
                ]
            ]);

        $expedition_services = 'jne, sicepat, kiriminaja';
        $result = (new SetWhitelistExpeditionService($expedition_services))->call();

        self::assertFalse($result->status);
        self::assertEquals("Parameter must be array", $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsEmpty(){
        (new PreferenceMock())->preferenceMock()
            ->shouldReceive([
                'setWhiteListExpedition' => [
                    false,
                    [
                        'status' => false,
                        'message'   => "Array of value Can't be empty",
                        'data' => null
                    ]
                ]
            ]);

        $expedition_services = ['', '', ''];
        $result = (new SetWhitelistExpeditionService($expedition_services))->call();

        self::assertFalse($result->status);
        self::assertEquals("Array of value Can't be empty", $result->message);
        self::assertEquals(null, $result->data);
    }
}
