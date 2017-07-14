<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entity;
use amoCRM\Repository\BaseEntityRepository;
use amoCRM\Repository\TasksRepository;
use amoCRM\Service\Interfaces\RequesterService;
use PHPUnit\Framework\TestCase;

/**
 * Class TasksRequesterTest
 * @package Tests\amoCRM\Entities
 */
final class TasksRepositoryTest extends TestCase
{
    /** @var RequesterService */
    private $requester;

    /**
     * @coversNothing
     */
    public function testInstanceOfBaseEntityRequester()
    {
        $this->assertInstanceOf(
            BaseEntityRepository::class,
            new TasksRepository($this->requester)
        );
    }

    /**
     * @covers \amoCRM\Repository\TasksRepository::__construct
     */
    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(RequesterService::class);

        $path = RequesterService::API_PATH.Entity\Task::TYPE_MANY.'/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = [Entity\Task::TYPE_MANY => ['add' => $elements]];
        $post_data = [
            'request' => [
                Entity\Task::TYPE_MANY => [
                    'add' => $elements,
                ],
            ],
        ];

        $requester
            ->expects($this->once())
            ->method('post')->with(
                $this->equalTo($path),
                $this->equalTo($post_data)
            )
            ->willReturn($post_result);

        $args = [
            $requester,
        ];

        $stub = $this->getMockBuilder(TasksRepository::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods()
            ->getMock();

        /** @var BaseEntityRepository $stub */
        $this->assertEquals($post_result[Entity\Task::TYPE_MANY]['add'], $stub->add($elements));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->requester = $this->createMock(RequesterService::class);
    }
}
