<?php

namespace Tests\amoCRM\Parser;

use amoCRM\Parser\DateParser;
use PHPUnit\Framework\TestCase;

/**
 * Class DateParserTest
 * @package Tests\amoCRM\Parser
 */
final class DateParserTest extends TestCase
{
    /**
     * @covers \amoCRM\Parser\DateParser::parseDate
     */
    public function testParseDateFromTimestamp()
    {
        $time = time();
        $result = DateParser::parseDate($time);
        $this->assertEquals($time, $result);
    }

    /**
     * @covers \amoCRM\Parser\DateParser::parseDate
     */
    public function testParseDateFromString()
    {
        $time = time();
        $result = DateParser::parseDate(date(\DateTime::ATOM, $time));
        $this->assertEquals($time, $result);
    }

    /**
     * @covers \amoCRM\Parser\DateParser::parseDate
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testParseDateThrowInvalidArgument()
    {
        DateParser::parseDate('test');
    }

    /**
     * @covers \amoCRM\Parser\DateParser::fromFormat
     */
    public function testFromFormat()
    {
        $time = time();
        $result = DateParser::fromFormat('d.m.Y', date('d.m.Y', $time));
        $this->assertEquals($time, $result);
    }

    /**
     * @covers \amoCRM\Parser\DateParser::fromFormat
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testFromFormatThrowInvalidArgument()
    {
        DateParser::fromFormat('d.m.Y', date(\DateTime::ATOM));
    }
}
