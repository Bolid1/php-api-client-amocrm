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
}
