<?php

namespace KiriminAja\Services\Preference\SetWhitelistExpeditionService;

require_once(__DIR__.'/../PreferenceMock.php');

use KiriminAja\Services\Preference\PreferenceMock;
use KiriminAja\Services\Preference\SetWhitelistExpeditionService;
use Mockery;
use PHPUnit\Framework\TestCase;

class SetWhitelistExpeditionServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testIsNotArray()
    {
        $this->tearDown();
        $this->expectException(\TypeError::class);

        $expedition_services = 'jne, sicepat, kiriminaja';
        (new SetWhitelistExpeditionService($expedition_services))->call();
    }

    public function testIsEmpty(){
        $this->tearDown();
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
