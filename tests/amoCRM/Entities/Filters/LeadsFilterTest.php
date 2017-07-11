<?php

namespace Tests\amoCRM\Entities\Filters;

use amoCRM\Entities\Filters\BaseEntityFilter;
use amoCRM\Entities\Filters\Interfaces\SearchFilter;
use amoCRM\Entities\Filters\LeadsFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadsFilterTest
 * @package Tests\amoCRM\Entities\Filters
 * @covers \amoCRM\Entities\Filters\LeadsFilter
 */
final class LeadsFilterTest extends TestCase
{
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
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveStatus()
    {
        (new LeadsFilter())->setStatus(0);
    }
}
