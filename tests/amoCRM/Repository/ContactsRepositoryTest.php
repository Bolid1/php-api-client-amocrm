<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entity\Contact;
use amoCRM\Interfaces\Requester;
use amoCRM\Repository\BaseEntityRepository;
use amoCRM\Repository\ContactsRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactsRequesterTest
 * @package Tests\amoCRM\Entities
 * @covers \amoCRM\Repository\ContactsRepository
 */
final class ContactsRepositoryTest extends TestCase
{
    /** @var Requester */
    private $requester;

    public function testInstanceOfBaseEntityRequester()
    {
        $this->assertInstanceOf(
            BaseEntityRepository::class,
            new ContactsRepository($this->requester)
        );
    }

    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(Requester::class);

        $path = Requester::API_PATH . Contact::TYPE_MANY . '/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = [Contact::TYPE_MANY => ['add' => $elements]];
        $post_data = [
            'request' => [
                Contact::TYPE_MANY => [
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

        $stub = $this->getMockBuilder(ContactsRepository::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods()
            ->getMock();

        /** @var BaseEntityRepository $stub */
        $this->assertEquals($post_result[Contact::TYPE_MANY]['add'], $stub->add($elements));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->requester = $this->createMock(Requester::class);
    }
}