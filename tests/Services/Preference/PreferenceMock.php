<?php

namespace KiriminAja\Services\Preference;

use KiriminAja\Repositories\PreferenceRepository;

class PreferenceMock
{
    public function preferenceMock()
    {
        return \Mockery::mock("overload:".PreferenceRepository::class);
    }
}
