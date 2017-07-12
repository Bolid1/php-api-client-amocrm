<?php

namespace Tests\amoCRM\Filter;

use amoCRM\Filter\BaseEntityFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseEntityFilterTest
 * @package Tests\amoCRM\Filter
 * @covers \amoCRM\Filter\BaseEntityFilter
 */
final class BaseEntityFilterTest extends TestCase
{
    public function testSetId()
    {
        $value = 1;
        $filter = $this->buildMock();
        $filter->setId($value);
        $this->assertEquals(['id' => (array)$value], $filter->toArray());
    }

    private function buildMock()
    {
        return $this->getMockBuilder(BaseEntityFilter::class)
            ->setMethods()
            ->getMock();
    }

    public function testSetQuery()
    {
        $value = 'test';
        $filter = $this->buildMock();
        $filter->setQuery($value);
        $this->assertEquals(['query' => $value], $filter->toArray());
    }

    public function testSetResponsibleUser()
    {
        $value = 1;
        $filter = $this->buildMock();
        $filter->setResponsibleUser($value);
        $this->assertEquals(['responsible_user_id' => (array)$value], $filter->toArray());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveId()
    {
        $this->buildMock()->setId(0);
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveResponsibleUser()
    {
        $this->buildMock()->setResponsibleUser(0);
    }
}
