<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\Task;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskTest
 * @package Tests\amoCRM\Entity
 */
final class TaskTest extends TestCase
{
    /**
     * @covers \amoCRM\Entity\Task::getStatuses
     */
    public function testGetStatuses()
    {
        $expected = [
            Task::STATUS_INCOMPLETE,
            Task::STATUS_COMPLETE,
        ];

        $this->assertEquals($expected, Task::getStatuses());
    }

    /**
     * @covers \amoCRM\Entity\Task::toAmo
     */
    public function testToAmo()
    {
        $task = new Task;
        $this->assertEmpty($task->toAmo());
        $this->assertInternalType('array', $task->toAmo());
    }

    /**
     * @covers \amoCRM\Entity\Task::setId
     * @covers \amoCRM\Entity\Task::getId
     */
    public function testSetId()
    {
        $value = 1;
        $task = new Task;
        $task->setId($value);
        $this->assertEquals($value, $task->getId());
    }

    /**
     * @covers \amoCRM\Entity\Task::setElementId
     * @covers \amoCRM\Entity\Task::getElementId
     */
    public function testSetElementId()
    {
        $value = 1;
        $task = new Task;
        $task->setElementId($value);
        $this->assertEquals($value, $task->getElementId());
    }

    /**
     * @covers \amoCRM\Entity\Task::setElementType
     * @covers \amoCRM\Entity\Task::ensureValidElementType
     * @covers \amoCRM\Entity\Task::getElementType
     */
    public function testSetElementType()
    {
        $value = 1;
        $task = new Task;
        $task->setElementType($value);
        $this->assertEquals($value, $task->getElementType());
    }

    /**
     * @covers \amoCRM\Entity\Task::ensureValidElementType
     * @uses   \amoCRM\Entity\Task::setElementType
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testSetElementTypeThrowInvalidArgument()
    {
        $value = 'test';
        $task = new Task;
        $task->setElementType($value);
    }

    /**
     * @covers \amoCRM\Entity\Task::setDateCreate
     * @covers \amoCRM\Entity\Task::getDateCreate
     */
    public function testSetDateCreate()
    {
        $value = time();
        $task = new Task;
        $task->setDateCreate($value);
        $this->assertEquals($value, $task->getDateCreate());
    }

    /**
     * @covers \amoCRM\Entity\Task::setDateModify
     * @covers \amoCRM\Entity\Task::getDateModify
     */
    public function testSetDateModify()
    {
        $value = time();
        $task = new Task;
        $task->setDateModify($value);
        $this->assertEquals($value, $task->getDateModify());
    }

    /**
     * @covers \amoCRM\Entity\Task::setModifiedBy
     * @covers \amoCRM\Entity\Task::getModifiedBy
     */
    public function testSetModifiedBy()
    {
        $value = 1;
        $task = new Task;
        $task->setModifiedBy($value);
        $this->assertEquals($value, $task->getModifiedBy());
    }

    /**
     * @covers \amoCRM\Entity\Task::setStatus
     * @covers \amoCRM\Entity\Task::ensureValidStatus
     * @covers \amoCRM\Entity\Task::getStatus
     */
    public function testSetStatus()
    {
        $value = Task::STATUS_INCOMPLETE;
        $task = new Task;
        $task->setStatus($value);
        $this->assertEquals($value, $task->getStatus());
    }

    /**
     * @covers \amoCRM\Entity\Task::ensureValidStatus
     * @uses   \amoCRM\Entity\Task::setStatus
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testSetStatusThrowValidateException()
    {
        $value = 3;
        $task = new Task;
        $task->setStatus($value);
    }

    /**
     * @covers \amoCRM\Entity\Task::setType
     * @covers \amoCRM\Entity\Task::getType
     */
    public function testSetType()
    {
        $value = 1;
        $task = new Task;
        $task->setType($value);
        $this->assertEquals($value, $task->getType());
    }

    /**
     * @covers \amoCRM\Entity\Task::setText
     * @covers \amoCRM\Entity\Task::getText
     */
    public function testSetText()
    {
        $value = 'some text';
        $task = new Task;
        $task->setText($value);
        $this->assertEquals($value, $task->getText());
    }

    /**
     * @covers \amoCRM\Entity\Task::setResponsible
     * @covers \amoCRM\Entity\Task::getResponsible
     */
    public function testSetResponsible()
    {
        $value = 1;
        $task = new Task;
        $task->setResponsible($value);
        $this->assertEquals($value, $task->getResponsible());
    }

    /**
     * @covers \amoCRM\Entity\Task::setCreatedBy
     * @covers \amoCRM\Entity\Task::getCreatedBy
     */
    public function testSetCreatedBy()
    {
        $value = 1;
        $task = new Task;
        $task->setCreatedBy($value);
        $this->assertEquals($value, $task->getCreatedBy());
    }

    /**
     * @covers \amoCRM\Entity\Task::setCompleteTill
     * @covers \amoCRM\Entity\Task::getCompleteTill
     */
    public function testSetCompleteTill()
    {
        $value = time();
        $task = new Task;
        $task->setCompleteTill($value);
        $this->assertEquals($value, $task->getCompleteTill());
    }
}
