<?php

namespace KiriminAja\Services\Preference\SetCallbackService;

require_once(__DIR__.'/../PreferenceMock.php');

use KiriminAja\Services\Preference\SetCallbackService;
use Mockery;
use PHPUnit\Framework\TestCase;

class SetCallbackServiceFailedTest extends TestCase
{

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testIsEmpty()
    {
        $this->expectException(\TypeError::class);

        $url = Null;
        (new SetCallbackService($url))->call();
    }
}
