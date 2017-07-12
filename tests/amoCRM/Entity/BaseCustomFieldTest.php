<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseCustomFieldTest
 * @package Tests\amoCRM\Entity
 * @coversDefaultClass \amoCRM\Entity\BaseCustomField
 */
final class BaseCustomFieldTest extends TestCase
{
    /** @var string */
    private static $default_value = 'result';

    /**
     * @TODO: Less covered methods
     * @covers ::__construct
     * @covers ::setId
     * @covers ::getId
     */
    public function testSetId()
    {
        $id = 25;
        $stub = $this->buildMock($id);

        $this->assertEquals($id, $stub->getId());
    }

    /**
     * @param integer $id
     * @return BaseCustomField
     */
    private function buildMock($id)
    {
        $stub = $this->getMockBuilder(BaseCustomField::class)
            ->setConstructorArgs([$id])
            ->setMethodsExcept(['toAmo', 'getId'])
            ->getMock();

        $stub
            ->method('valueToAmo')
            ->willReturn(self::$default_value);

        /** @var BaseCustomField $stub */
        return $stub;
    }

    /**
     * @covers ::toAmo
     */
    public function testToAmo()
    {
        $id = 25;
        $stub = $this->buildMock($id);

        $this->assertEquals(['id' => $id, 'values' => self::$default_value], $stub->toAmo());
    }
}
