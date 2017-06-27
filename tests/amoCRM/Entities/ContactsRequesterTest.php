<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entities\BaseEntityRequester;
use amoCRM\Entities\ContactsRequester;
use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

class ContactsRequesterTest extends TestCase
{
    /** @var Requester */
    private $_requester;

    public function testInstanceOfBaseEntityRequester()
    {
        $this->assertInstanceOf(
            BaseEntityRequester::class,
            new ContactsRequester($this->_requester)
        );
    }

    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(Requester::class);

        $path = Requester::API_PATH . 'contacts/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = ['contacts' => ['add' => $elements]];
        $post_data = [
            'request' => [
                'contacts' => [
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

        $stub = $this->getMockBuilder(ContactsRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods(null)
            ->getMock();

        /** @var BaseEntityRequester $stub */
        $this->assertEquals($post_result['contacts']['add'], $stub->add($elements));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_requester = $this->createMock(Requester::class);
    }
}
