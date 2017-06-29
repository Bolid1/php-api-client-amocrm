<?php

namespace Tests\amoCRM\Entities\Filters;

use amoCRM\Entities\Filters\BaseEntityFilter;
use amoCRM\Entities\Filters\Interfaces\SearchFilter;
use amoCRM\Entities\Filters\LeadsFilter;
use PHPUnit\Framework\TestCase;

class LeadsFilterTest extends TestCase
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
            'id' => [1],
            'query' => 'test',
            'responsible_user_id' => [1],
            'status' => [1],
        ];

        $filter = new LeadsFilter();
        $filter->setId($expected['id']);
        $filter->setQuery($expected['query']);
        $filter->setResponsibleUser($expected['responsible_user_id']);
        $filter->setStatus($expected['status']);

        $this->assertEquals($expected, $filter->toArray());
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveId()
    {
        (new LeadsFilter())->setId(0);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveResponsibleUser()
    {
        (new LeadsFilter())->setResponsibleUser(0);
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
