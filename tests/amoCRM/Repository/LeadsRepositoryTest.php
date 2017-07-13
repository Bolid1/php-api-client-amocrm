<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entity;
use amoCRM\Repository\BaseEntityRepository;
use amoCRM\Repository\LeadsRepository;
use amoCRM\Service\Interfaces\RequesterService;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadsRequesterTest
 * @package Tests\amoCRM\Entities
 */
final class LeadsRepositoryTest extends TestCase
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
            new LeadsRepository($this->requester)
        );
    }

    /**
     * @covers \amoCRM\Repository\LeadsRepository::__construct
     */
    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(RequesterService::class);

        $path = RequesterService::API_PATH.Entity\Lead::TYPE_MANY.'/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = [Entity\Lead::TYPE_MANY => ['add' => $elements]];
        $post_data = [
            'request' => [
                Entity\Lead::TYPE_MANY => [
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

        $stub = $this->getMockBuilder(LeadsRepository::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods()
            ->getMock();

        /** @var BaseEntityRepository $stub */
        $this->assertEquals($post_result[Entity\Lead::TYPE_MANY]['add'], $stub->add($elements));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->requester = $this->createMock(RequesterService::class);
    }
}
