<?php

namespace Tests\amoCRM\Filter;

use amoCRM\Filter\BaseEntityFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseEntityFilterTest
 * @package Tests\amoCRM\Filter
 */
final class BaseEntityFilterTest extends TestCase
{
    /**
     * @covers \amoCRM\Filter\BaseEntityFilter::toArray
     */
    public function testToArray()
    {
        $filter = $this->buildMock();
        $filter->setId(1);
        $filter->setQuery('test');
        $filter->setResponsibleUser(1);

        $expected = [
            'id' => $filter->getId(),
            'query' => $filter->getQuery(),
            'responsible_user_id' => $filter->getResponsibleUser(),
        ];
        $this->assertEquals($expected, $filter->toArray());
    }

    private function buildMock()
    {
        return $this->getMockBuilder(BaseEntityFilter::class)
            ->setMethods()
            ->getMock();
    }

    /**
     * @covers \amoCRM\Filter\BaseEntityFilter::setId
     * @covers \amoCRM\Filter\BaseEntityFilter::getId
     */
    public function testSetId()
    {
        $value = 1;
        $filter = $this->buildMock();
        $filter->setId($value);
        $this->assertEquals([$value], $filter->getId());
    }

    /**
     * @covers \amoCRM\Filter\BaseEntityFilter::setQuery
     * @covers \amoCRM\Filter\BaseEntityFilter::getQuery
     */
    public function testSetQuery()
    {
        $value = 'test';
        $filter = $this->buildMock();
        $filter->setQuery($value);
        $this->assertEquals($value, $filter->getQuery());
    }

    /**
     * @covers \amoCRM\Filter\BaseEntityFilter::setResponsibleUser
     * @covers \amoCRM\Filter\BaseEntityFilter::getResponsibleUser
     */
    public function testSetResponsibleUser()
    {
        $value = 1;
        $filter = $this->buildMock();
        $filter->setResponsibleUser($value);
        $this->assertEquals((array)$value, $filter->getResponsibleUser());
    }

    /**
     * @covers \amoCRM\Filter\BaseEntityFilter::setId
     * @uses   \amoCRM\Validator\NumberValidator::parseIntegersArray
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testThrowNotPositiveId()
    {
        $this->buildMock()->setId(0);
    }

    /**
     * @covers \amoCRM\Filter\BaseEntityFilter::setResponsibleUser
     * @uses   \amoCRM\Validator\NumberValidator::parseIntegersArray
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testThrowNotPositiveResponsibleUser()
    {
        $this->buildMock()->setResponsibleUser(0);
    }
}
