<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entities\Elements;
use PHPUnit\Framework\TestCase;
use amoCRM\Interfaces\Requester;
use amoCRM\Entities\BaseEntityRequester as BaseEntityRequester;

/**
 * Class BaseEntityRequesterTest
 * @package Tests\amoCRM\Entities
 * @covers \amoCRM\Entities\BaseEntityRequester
 */
final class BaseEntityRequesterTest extends TestCase
{
    public function testCanBeCreatedFromValidNamesAndPaths()
    {
        $args = [
			$this->createMock(Requester::class),
			['many' => Elements\Lead::TYPE_MANY],
			['set' => Elements\Lead::TYPE_MANY . '/set'],
        ];

        $stub = $this->getMockBuilder(BaseEntityRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            ->getMock();


        $this->assertInstanceOf(
            BaseEntityRequester::class,
            $stub
        );
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidNames()
    {
        $args = [
            $this->createMock(Requester::class),
            ['many' => null],
            ['set' => Elements\Lead::TYPE_MANY . '/set'],
        ];

        $this->getMockBuilder(BaseEntityRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            ->getMock();
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidPaths()
    {
        $args = [
            $this->createMock(Requester::class),
            ['many' => Elements\Lead::TYPE_MANY],
            ['set' => null],
        ];

        $this->getMockBuilder(BaseEntityRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            ->getMock();
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testBuildFailedForAdd()
    {
        $requester = $this->createMock(Requester::class);

        // Wrong nesting level
        $elements = ['name' => 'Test'];

        $args = [
            $requester,
            ['many' => 'elements'],
            ['set' => 'elements/set'],
        ];

        $stub = $this->getMockBuilder(BaseEntityRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods(null)
            ->getMock();

        /** @var BaseEntityRequester $stub */
        $stub->add($elements);
    }

    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(Requester::class);

        $path = Requester::API_PATH . 'elements/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = ['elements' => ['add' => $elements]];
        $post_data = [
            'request' => [
                'elements' => [
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
            ['many' => 'elements'],
            ['set' => 'elements/set'],
        ];

        $stub = $this->getMockBuilder(BaseEntityRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods(null)
            ->getMock();

        /** @var BaseEntityRequester $stub */
        $this->assertEquals($post_result['elements']['add'], $stub->add($elements));
    }

    public function testAddErrorResult()
    {
        $requester = $this->createMock(Requester::class);

        $path = Requester::API_PATH . 'elements/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = ['error' => 'test error', 'error_code' => 102];
        $post_data = [
            'request' => [
                'elements' => [
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
            ['many' => 'elements'],
            ['set' => 'elements/set'],
        ];

        $stub = $this->getMockBuilder(BaseEntityRequester::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods(null)
            ->getMock();

        /** @var BaseEntityRequester $stub */
        $this->assertEquals($post_result, $stub->add($elements));
    }
}
