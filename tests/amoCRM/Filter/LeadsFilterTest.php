<?php

namespace Tests\amoCRM\Filter;

use amoCRM\Filter\BaseEntityFilter;
use amoCRM\Filter\Interfaces\SearchFilter;
use amoCRM\Filter\LeadsFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadsFilterTest
 * @package Tests\amoCRM\Filter
 */
final class LeadsFilterTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testInstanceOf()
    {
        $filter = new LeadsFilter();

        $this->assertInstanceOf(
            SearchFilter::class,
            $filter
        );

        $this->assertInstanceOf(
            BaseEntityFilter::class,
            $filter
        );
    }

    /**
     * @covers \amoCRM\Filter\LeadsFilter::setStatus
     * @covers \amoCRM\Filter\LeadsFilter::toArray
     */
    public function testCases()
    {
        $expected = [
            'status' => [1],
        ];

        $filter = new LeadsFilter();
        $filter->setStatus($expected['status']);

        $this->assertEquals($expected, $filter->toArray());
    }

    /**
     * @covers \amoCRM\Filter\LeadsFilter::setStatus
     * @uses   \amoCRM\Parser\NumberParser::parseIntegersArray
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testThrowNotPositiveStatus()
    {
        (new LeadsFilter())->setStatus(0);
    }
}
