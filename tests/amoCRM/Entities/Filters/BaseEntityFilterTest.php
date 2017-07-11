<?php
/**
 * Created by PhpStorm.
 * User: vdvug
 * Date: 11.07.2017
 * Time: 21:56
 */

namespace Tests\amoCRM\Entities\Filters;

use amoCRM\Entities\Filters\BaseEntityFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseEntityFilterTest
 * @package Tests\amoCRM\Entities\Filters
 * @covers \amoCRM\Entities\Filters\BaseEntityFilter
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
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveId()
    {
        $this->buildMock()->setId(0);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Must be greater than zero, "0" given
     */
    public function testThrowNotPositiveResponsibleUser()
    {
        $this->buildMock()->setResponsibleUser(0);
    }
}
