<?php

namespace Tests\amoCRM\Validator;

use amoCRM\Validator\NumberValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class NumberValidatorTest
 * @package Tests\amoCRM\Validator
 */
final class NumberValidatorTest extends TestCase
{
    /**
     * @covers \amoCRM\Validator\NumberValidator::parseInteger
     * @covers \amoCRM\Validator\NumberValidator::ensureIsNumeric
     * @covers \amoCRM\Validator\NumberValidator::ensureGreaterOrEqualZero
     * @covers \amoCRM\Validator\NumberValidator::ensureNotEqualZero
     */
    public function testParseInteger()
    {
        $result = NumberValidator::parseInteger('1');
        $this->assertInternalType('int', $result);
        $this->assertEquals(1, $result);
    }

    /**
     * @covers \amoCRM\Validator\NumberValidator::ensureIsNumeric
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testEnsureIsNumeric()
    {
        NumberValidator::parseInteger('test');
    }

    /**
     * @covers \amoCRM\Validator\NumberValidator::ensureGreaterOrEqualZero
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testEnsureGreaterOrEqualZero()
    {
        NumberValidator::parseInteger(-1);
    }

    /**
     * @covers \amoCRM\Validator\NumberValidator::ensureNotEqualZero
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testEnsureNotEqualZero()
    {
        NumberValidator::parseInteger(0);
    }
}
