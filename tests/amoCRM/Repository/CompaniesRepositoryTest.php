<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entity\Company;
use amoCRM\Repository\BaseEntityRepository;
use amoCRM\Repository\CompaniesRepository;
use amoCRM\Service\Interfaces\RequesterService;
use PHPUnit\Framework\TestCase;

/**
 * Class CompaniesRequesterTest
 * @package Tests\amoCRM\Entities
 */
final class CompaniesRepositoryTest extends TestCase
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
            new CompaniesRepository($this->requester)
        );
    }

    /**
     * @covers \amoCRM\Repository\CompaniesRepository::__construct
     */
    public function testBuildValidFormatForAdd()
    {
        $requester = $this->createMock(RequesterService::class);

        $path = RequesterService::API_PATH.Company::TYPE_SINGLE.'/set';
        $elements = [
            [
                'name' => 'Test',
            ],
        ];
        $post_result = [Company::TYPE_MANY => ['add' => $elements]];
        $post_data = [
            'request' => [
                Company::TYPE_MANY => [
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

        $stub = $this->getMockBuilder(CompaniesRepository::class)
            ->setConstructorArgs($args)
            ->enableOriginalConstructor()
            // Disable mock of any methods
            ->setMethods()
            ->getMock();

        /** @var BaseEntityRepository $stub */
        $this->assertEquals($post_result[Company::TYPE_MANY]['add'], $stub->add($elements));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->requester = $this->createMock(RequesterService::class);
    }
}
