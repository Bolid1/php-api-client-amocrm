<?php

namespace Tests\amoCRM\Unsorted\UnsortedFormFields;

use PHPUnit\Framework\TestCase;
use amoCRM\Entities\Elements\Lead;
use amoCRM\Unsorted\UnsortedFormFields\BaseFormField;

/**
 * Class BaseFormFieldTest
 * @package Tests\amoCRM\Unsorted\UnsortedFormFields
 * @covers \amoCRM\Unsorted\UnsortedFormFields\BaseFormField
 */
final class BaseFormFieldTest extends TestCase
{
    private $_default = [
        'id' => 'name',
        'type' => 'text',
        'element_type' => Lead::TYPE_NUMERIC,
    ];

    public function testManageId()
    {
        $field = $this->buildMock();
        $this->assertEquals($this->_default['id'], $field->getId());
    }

    public function testManageType()
    {
        $field = $this->buildMock();
        $this->assertEquals($this->_default['type'], $field->getType());
    }

    public function testManageElementType()
    {
        $field = $this->buildMock();
        $this->assertEquals($this->_default['element_type'], $field->getElementType());
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Incorrect element type "21"
     */
    public function testManageElementTypeThrowInvalidArgument()
    {
        $this->buildMock([$this->_default['id'], $this->_default['type'], 21]);
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
        $this->assertEquals($this->_default + ['name' => null, 'value' => null], $field->toAmo());
    }

    /**
     * @param array $args
     * @return BaseFormField
     */
    protected function buildMock($args = null)
    {
        if (!isset($args)) {
            $args = [$this->_default['id'], $this->_default['type'], $this->_default['element_type']];
        }

        $field = $this
            ->getMockBuilder(BaseFormField::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs($args)
            ->setMethods(null)
            ->getMock();

        /** @var BaseFormField $field */
        return $field;
    }
}
