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
    private static $default_enums = [
        1 => 'one',
        2 => 'two',
        3 => 'three',
    ];
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldRadioButton($this->default_id, self::$default_enums)
        );
    }

    public function testSetValue()
    {
        $cf = new CustomFieldRadioButton($this->default_id, self::$default_enums);
        $value = reset(self::$default_enums);

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetValueThrowInvalidArgumentException()
    {
        $cf = new CustomFieldRadioButton($this->default_id, self::$default_enums);
        $value = 'four';

        $this->assertNotContains($value, self::$default_enums);
        $cf->setValue($value);
    }

    public function testSetEnum()
    {
        $cf = new CustomFieldRadioButton($this->default_id, self::$default_enums);
        $value = reset(self::$default_enums);
        $enum = key(self::$default_enums);

        $cf->setEnum($enum);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetEnumThrowInvalidArgumentException()
    {
        $cf = new CustomFieldRadioButton($this->default_id, self::$default_enums);
        $enum = 4;

        $this->assertFalse(isset(self::$default_enums[$enum]));
        $cf->setEnum($enum);
    }
}
