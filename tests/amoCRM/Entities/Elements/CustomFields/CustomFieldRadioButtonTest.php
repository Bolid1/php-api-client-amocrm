<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\BaseCustomField;
use amoCRM\Entities\Elements\CustomFields\CustomFieldRadioButton;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldRadioButtonTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldRadioButton
 */
final class CustomFieldRadioButtonTest extends TestCase
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
            new CustomFieldRadioButton($this->_default_id, $this->_default_enums)
        );
    }

    public function testSetValue()
    {
        $cf = new CustomFieldRadioButton($this->_default_id, $this->_default_enums);
        $value = reset($this->_default_enums);

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->_default_id, 'values' => [['value' => $value]]], $data);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetValueThrowInvalidArgumentException()
    {
        $cf = new CustomFieldRadioButton($this->_default_id, $this->_default_enums);
        $value = 'four';

        $this->assertNotContains($value, $this->_default_enums);
        $cf->setValue($value);
    }

    public function testSetEnum()
    {
        $cf = new CustomFieldRadioButton($this->_default_id, $this->_default_enums);
        $value = reset($this->_default_enums);
        $enum = key($this->_default_enums);

        $cf->setEnum($enum);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->_default_id, 'values' => [['value' => $value]]], $data);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetEnumThrowInvalidArgumentException()
    {
        $cf = new CustomFieldRadioButton($this->_default_id, $this->_default_enums);
        $enum = 4;

        $this->assertFalse(isset($this->_default_enums[$enum]));
        $cf->setEnum($enum);
    }
}
