<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\BaseCustomField;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseCustomFieldTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\BaseCustomField
 */
final class BaseCustomFieldTest extends TestCase
{
    /** @var string */
    private static $default_value = 'result';
    /** @var int */
    protected $default_id = 25;

    public function testSetId()
    {
        $stub = $this->buildMock();

        $this->assertEquals(['id' => $this->default_id, 'values' => self::$default_value], $stub->toAmo());
    }

    /**
     * @param integer $id
     * @return BaseCustomField
     */
    private function buildMock($id = null)
    {
        if ($id === null) {
            $id = $this->default_id;
        }

        $stub = $this->getMockBuilder(BaseCustomField::class)
            ->setConstructorArgs([$id])
            ->setMethodsExcept(['toAmo'])
            ->getMock();

        $stub
            ->method('valueToAmo')
            ->willReturn(self::$default_value);

        /** @var BaseCustomField $stub */
        return $stub;
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetIdThrowInvalidArgumentNaN()
    {
        $this->buildMock('some string');
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetIdThrowInvalidArgumentPositive()
    {
        $this->buildMock(-1);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetIdThrowInvalidArgumentZero()
    {
        $this->buildMock(0);
    }
}
