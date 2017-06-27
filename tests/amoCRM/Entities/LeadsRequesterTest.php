<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entities\BaseEntityRequester;
use amoCRM\Entities\LeadsRequester;
use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

class LeadsRequesterTest extends TestCase
{
    /** @var Requester */
    private $_requester;

    public function testInstanceOfBaseEntityRequester()
    {
        $this->assertInstanceOf(
            BaseEntityRequester::class,
            new LeadsRequester($this->_requester)
        );
    }

    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(Requester::class);

        $path = Requester::API_PATH . 'leads/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = ['leads' => ['add' => $elements]];
        $post_data = [
            'request' => [
                'leads' => [
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
            ->setMethods(null)
            ->getMock();

        /** @var BaseEntityRequester $stub */
        $this->assertEquals($post_result['leads']['add'], $stub->add($elements));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_requester = $this->createMock(Requester::class);
    }
}
