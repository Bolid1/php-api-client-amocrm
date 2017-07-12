<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entities\BaseEntityRequester;
use amoCRM\Entities\LeadsRequester;
use amoCRM\Entity;
use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadsRequesterTest
 * @package Tests\amoCRM\Entities
 * @covers \amoCRM\Entities\LeadsRequester
 */
final class LeadsRequesterTest extends TestCase
{
    /** @var Requester */
    private $requester;

    public function testInstanceOfBaseEntityRequester()
    {
        $this->assertInstanceOf(
            BaseEntityRequester::class,
            new LeadsRequester($this->requester)
        );
    }

    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(Requester::class);

        $path = Requester::API_PATH.Entity\Lead::TYPE_MANY.'/set';
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

        $stub = $this->getMockBuilder(LeadsRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods()
            ->getMock();

        /** @var BaseEntityRequester $stub */
        $this->assertEquals($post_result[Entity\Lead::TYPE_MANY]['add'], $stub->add($elements));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->requester = $this->createMock(Requester::class);
    }
}
