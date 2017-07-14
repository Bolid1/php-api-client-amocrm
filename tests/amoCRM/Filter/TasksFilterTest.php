<?php

namespace Tests\amoCRM\Filter;

use amoCRM\Entity;
use amoCRM\Filter\Interfaces\SearchFilter;
use amoCRM\Filter\TasksFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class TasksFilterTest
 * @package Tests\amoCRM\Filter
 */
final class TasksFilterTest extends TestCase
{
    /** @coversNothing */
    public function testInstanceOf()
    {
        $this->assertInstanceOf(
            SearchFilter::class,
            new TasksFilter
        );
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::setId
     * @covers \amoCRM\Filter\TasksFilter::getId
     */
    public function testGetId()
    {
        $value = 1;
        $filter = new TasksFilter;
        $filter->setId($value);
        $this->assertEquals([$value], $filter->getId());
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::setElementType
     * @covers \amoCRM\Filter\TasksFilter::ensureValidElementType
     * @covers \amoCRM\Filter\TasksFilter::getElementType
     */
    public function testGetElementType()
    {
        $value = Entity\Lead::TYPE_SINGLE;
        $filter = new TasksFilter;
        $filter->setElementType($value);
        $this->assertEquals($value, $filter->getElementType());
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::ensureValidElementType
     * @uses   \amoCRM\Filter\TasksFilter::setElementType
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testThrowInvalidElementType()
    {
        $filter = new TasksFilter;
        $filter->setElementType('test');
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::setElementId
     * @covers \amoCRM\Filter\TasksFilter::getElementId
     */
    public function testGetElementId()
    {
        $value = 1;
        $filter = new TasksFilter;
        $filter->setElementId($value);
        $this->assertEquals([$value], $filter->getElementId());
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::setStatus
     * @covers \amoCRM\Filter\TasksFilter::ensureValidStatus
     * @covers \amoCRM\Filter\TasksFilter::getStatus
     */
    public function testGetStatus()
    {
        $value = Entity\Task::STATUS_COMPLETE;
        $filter = new TasksFilter;
        $filter->setStatus($value);
        $this->assertEquals($value, $filter->getStatus());
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::ensureValidStatus
     * @uses   \amoCRM\Filter\TasksFilter::setStatus
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testThrowInvalidStatus()
    {
        $filter = new TasksFilter;
        $filter->setStatus(25);
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::setResponsibleUser
     * @covers \amoCRM\Filter\TasksFilter::getResponsibleUser
     */
    public function testGetResponsibleUser()
    {
        $value = 1;
        $filter = new TasksFilter;
        $filter->setResponsibleUser($value);
        $this->assertEquals([$value], $filter->getResponsibleUser());
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::getElementTypes
     */
    public function testGetElementTypes()
    {
        $tasks_elements_types = [
            Entity\Contact::TYPE_SINGLE,
            Entity\Lead::TYPE_SINGLE,
            Entity\Company::TYPE_SINGLE,
        ];

        $this->assertEquals($tasks_elements_types, TasksFilter::getElementTypes());
    }

    /**
     * @covers \amoCRM\Filter\TasksFilter::toArray
     * @uses   \amoCRM\Filter\TasksFilter::setId
     * @uses   \amoCRM\Filter\TasksFilter::setElementId
     * @uses   \amoCRM\Filter\TasksFilter::setResponsibleUser
     * @uses   \amoCRM\Filter\TasksFilter::setStatus
     */
    public function testToArray()
    {
        $expected = [
            'id' => [1, 2, 3],
            'element_id' => [4, 5, 6],
            'type' => Entity\Contact::TYPE_SINGLE,
            'responsible_user_id' => [7, 8, 9],
            'filter' => [
                'status' => Entity\Task::STATUS_COMPLETE,
            ],
        ];

        $filter = new TasksFilter;

        $filter->setId($expected['id']);
        $filter->setElementId($expected['element_id']);
        $filter->setResponsibleUser($expected['responsible_user_id']);
        $filter->setStatus($expected['filter']['status']);

        $this->assertEquals($expected, $filter->toArray());
    }
}
