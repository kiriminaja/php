<?php

namespace KiriminAja\Unit\Preference\SetWhitelistExpeditionService;

use KiriminAja\Services\Preference\SetWhitelistExpeditionService;
use KiriminAja\Unit\Preference\PreferenceMock;
use PHPUnit\Framework\TestCase;

class SetWhitelistExpeditionServiceValidationFailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function test()
    {
        $services = 'sicepat';
        $result = (new SetWhitelistExpeditionService($services))->call();
        self::assertFalse($result->status);
    }
}
