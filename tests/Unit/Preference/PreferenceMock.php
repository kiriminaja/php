<?php

namespace KiriminAja\Unit\Preference;

use KiriminAja\Repositories\PreferenceRepository;
use PHPUnit\Framework\TestCase;

class PreferenceMock extends TestCase
{
    public function preferenceMock()
    {
        return \Mockery::mock("overload:".PreferenceRepository::class);
    }
}
