<?php

namespace KiriminAja\Unit\Shipping;

use KiriminAja\Base\Config\KiriminAjaConfig;
use KiriminAja\Services\KiriminAja;
use PHPUnit\Framework\TestCase;

class ScheduleServiceTest extends TestCase {

    public function testScheduleService() {

        $schedules = KiriminAja::getSchedules();

//        echo "\nresults : ".json_encode($schedules);

        self::assertTrue(true);
    }

}
