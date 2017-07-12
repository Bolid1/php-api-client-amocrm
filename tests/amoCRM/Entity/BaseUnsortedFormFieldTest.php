<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseUnsortedFormField;
use amoCRM\Entity\Lead;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseUnsortedFormFieldTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\BaseUnsortedFormField
 */
final class BaseUnsortedFormFieldTest extends TestCase
{
    private static $default = [
        'id' => 'name',
        'type' => 'text',
        'element_type' => Lead::TYPE_NUMERIC,
    ];

    public function testManageId()
    {
        $field = $this->buildMock();
        $this->assertEquals(self::$default['id'], $field->getId());
    }

    /**
     * @param array $args
     * @return BaseUnsortedFormField
     */
    protected function buildMock($args = null)
    {
        if ($args === null) {
            $args = [self::$default['id'], self::$default['type'], self::$default['element_type']];
        }

        $field = $this
            ->getMockBuilder(BaseUnsortedFormField::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs($args)
            ->setMethods()
            ->getMock();

        /** @var BaseUnsortedFormField $field */
        return $field;
    }

    public function testManageType()
    {
        $field = $this->buildMock();
        $this->assertEquals(self::$default['type'], $field->getType());
    }

    public function testManageElementType()
    {
        $field = $this->buildMock();
        $this->assertEquals(self::$default['element_type'], $field->getElementType());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     * @expectedExceptionMessage Incorrect element type "21"
     */
    public function testManageElementTypeThrowInvalidArgument()
    {
        $this->buildMock([self::$default['id'], self::$default['type'], 21]);
    }

    public function testManageName()
    {
        $field = $this->buildMock();

        $value = 'test';
        $field->setName($value);
        $this->assertEquals($value, $field->getName());
    }

    public function testGetValue()
    {
        $field = $this->buildMock();
        $this->assertNull($field->getValue());
        $field->setValue('test');
        $this->assertEquals('test', $field->getValue());
    }

    public function testToAmo()
    {
        $field = $this->buildMock();
        $this->assertEquals(self::$default + ['name' => null, 'value' => null], $field->toAmo());
    }
}
