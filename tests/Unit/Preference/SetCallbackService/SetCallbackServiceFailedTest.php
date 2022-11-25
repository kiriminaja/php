<?php

namespace KiriminAja\Unit\Preference\SetCallbackService;

require_once(__DIR__.'/../PreferenceMock.php');

use KiriminAja\Services\Preference\SetCallbackService;
use KiriminAja\Unit\Preference\PreferenceMock;
use PHPUnit\Framework\TestCase;
use Mockery;

class SetCallbackServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testIsEmpty()
    {
        (new PreferenceMock())->preferenceMock()
            ->shouldReceive([
                'setCallback' => [
                    false,
                    [
                        'status' => false,
                        'message'   => "Url Params Can't be Blank",
                        'data' => null
                    ]
                ]
            ]);

        $url = Null;
        $result = (new SetCallbackService($url))->call();

        self::assertFalse($result->status);
        self::assertEquals("Url Params Can't be Blank", $result->message);
        self::assertEquals(null, $result->data);
    }

    public function testIsInteger(){

        (new PreferenceMock())->preferenceMock()
            ->shouldReceive([
                'setCallback' => [
                    false,
                    [
                        'status' => false,
                        'message'   => "Url params must be an string",
                        'data' => null
                    ]
                ]
            ]);

        $url = 12;
        $result = (new SetCallbackService($url))->call();

        self::assertFalse($result->status);
        self::assertEquals("Url params must be an string", $result->message);
        self::assertEquals(null, $result->data);
    }
}
