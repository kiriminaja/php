<?php

namespace Tests\Utils;

use KiriminAja\Utils\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidatesRequiredNumericValue(): void
    {
        $result = Validator::validate(
            ['province_id' => 12],
            ['province_id' => 'required|numeric']
        );

        $this->assertTrue($result->passes());
        $this->assertSame([], $result->errors());
    }

    public function testReturnsCustomRequiredMessage(): void
    {
        $result = Validator::validate(
            ['province_id' => ''],
            ['province_id' => 'required|numeric'],
            ['province_id' => ['required' => 'Province is required.']]
        );

        $this->assertTrue($result->fails());
        $this->assertSame(['Province is required.', 'The province_id field must be numeric.'], $result->errors());
    }

    public function testMissingNumericValueOnlyReportsRequired(): void
    {
        $result = Validator::validate([], ['province_id' => 'required|numeric']);

        $this->assertSame(['The province_id field is required.'], $result->errors());
    }
}
