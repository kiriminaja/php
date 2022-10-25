<?php

namespace KiriminAja\Unit\Preference\SetCallbackService;

use KiriminAja\Services\Preference\SetCallbackService;
use KiriminAja\Unit\Preference\PreferenceMock;
use PHPUnit\Framework\TestCase;

class SetCallbackServiceSuccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        (new PreferenceMock())->preferenceMock()
            ->shouldReceive([
                'setCallback' => [
                    true,
                    [
                        'status' => true,
                        'text'   => "success get prefence data",
                        'datas'  => [
                            'id'   => 1,
                            'name' => 'mock preference data'
                        ]
                    ]
                ]
            ]);
    }

    public function test()
    {
        $url = 'https://mock.preference.com';
        $result = (new SetCallbackService($url))->call();
        self::assertTrue($result->status);
    }
}