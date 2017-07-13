<?php

namespace Tests\amoCRM\Validator;

use amoCRM\Parser\NumberParser;
use PHPUnit\Framework\TestCase;

/**
 * Class NumberValidatorTest
 * @package Tests\amoCRM\Validator
 */
final class NumberParserTest extends TestCase
{
    /**
     * @covers \amoCRM\Parser\NumberParser::parseInteger
     * @covers \amoCRM\Parser\NumberParser::ensureIsNumeric
     * @covers \amoCRM\Parser\NumberParser::ensureGreaterOrEqualZero
     * @covers \amoCRM\Parser\NumberParser::ensureNotEqualZero
     */
    public function testParseInteger()
    {
        $result = NumberParser::parseInteger('1');
        $this->assertInternalType('int', $result);
        $this->assertEquals(1, $result);
    }

    /**
     * @covers \amoCRM\Parser\NumberParser::ensureIsNumeric
     * @uses   \amoCRM\Parser\NumberParser::parseInteger
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testEnsureIsNumeric()
    {
        NumberParser::parseInteger('test');
    }

    /**
     * @covers \amoCRM\Parser\NumberParser::ensureGreaterOrEqualZero
     * @uses   \amoCRM\Parser\NumberParser::parseInteger
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testEnsureGreaterOrEqualZero()
    {
        NumberParser::parseInteger(-1);
    }

    /**
     * @covers \amoCRM\Parser\NumberParser::ensureNotEqualZero
     * @uses   \amoCRM\Parser\NumberParser::parseInteger
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testEnsureNotEqualZero()
    {
        NumberParser::parseInteger(0);
    }

    /**
     * @covers \amoCRM\Parser\NumberParser::parseIntegersArray
     */
    public function testParseIntegersArray()
    {
        $arr = ['1', '2', '3'];
        $result = NumberParser::parseIntegersArray($arr);
        $this->assertEquals($arr, $result);
        foreach ($result as $item) {
            $this->assertInternalType('int', $item);
        }
    }
}
