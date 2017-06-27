<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\BaseCustomField;
use amoCRM\Entities\Elements\CustomFields\CustomFieldSelect;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldSelectTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldSelect
 */
final class CustomFieldSelectTest extends TestCase
{
    /** @var integer */
    private $_default_id = 25;

    /** @var array */
    private $_default_enums = [
        1 => 'one',
        2 => 'two',
        3 => 'three',
    ];

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldSelect($this->_default_id, $this->_default_enums)
        );
    }

    public function testSetValue()
    {
        $cf = new CustomFieldSelect($this->_default_id, $this->_default_enums);
        $value = reset($this->_default_enums);
        $enum = key($this->_default_enums);

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->_default_id, 'values' => [['value' => $enum]]], $data);
        $this->assertInternalType('integer', $data['values'][0]['value']);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetValueThrowInvalidArgumentException()
    {
        $cf = new CustomFieldSelect($this->_default_id, $this->_default_enums);
        $value = 'four';

        $this->assertNotContains($value, $this->_default_enums);
        $cf->setValue($value);
    }

    public function testSetEnum()
    {
        $cf = new CustomFieldSelect($this->_default_id, $this->_default_enums);
        $enum = key($this->_default_enums);

        $cf->setEnum($enum);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->_default_id, 'values' => [['value' => $enum]]], $data);
        $this->assertInternalType('integer', $data['values'][0]['value']);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetEnumThrowInvalidArgumentException()
    {
        $cf = new CustomFieldSelect($this->_default_id, $this->_default_enums);
        $enum = 4;

        $this->assertFalse(isset($this->_default_enums[$enum]));
        $cf->setEnum($enum);
    }
}
