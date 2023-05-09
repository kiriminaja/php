<?php

namespace KiriminAja\Services\Config;

use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Base\Config\KiriminAjaConfig;
use PHPUnit\Framework\TestCase;

class KiriminAjaConfigTest extends TestCase {

    public function testKiriminAjaConfigSuccess() {

        $expectedKey = "234342343";

        KiriminAjaConfig::setMode(Mode::Staging)->setApiTokenKey($expectedKey);

        $key = KiriminAjaConfig::apiKey()->getKey();
//        echo "\nAPI key : ".$key;

        self::assertTrue($key == $expectedKey);
    }

}
