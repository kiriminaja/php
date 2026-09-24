<?php

namespace KiriminAja\Services\Profile;

use KiriminAja\Repositories\ProfileRepository;

class ProfileMock
{
    protected \Mockery\MockInterface|\Mockery\LegacyMockInterface|null $mockery = null;

    public function profileMock()
    {
        $this->mockery = \Mockery::mock('overload:' . ProfileRepository::class);

        return $this->mockery;
    }
}
