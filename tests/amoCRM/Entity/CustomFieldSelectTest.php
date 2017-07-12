<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\CustomFieldSelect;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldSelectTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldSelect
 */
final class CustomFieldSelectTest extends TestCase
{
    /** @var array */
    private static $default_enums = [
        1 => 'one',
        2 => 'two',
        3 => 'three',
    ];
    /** @var integer */
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldSelect($this->default_id, self::$default_enums)
        );
    }

    public function testSetValue()
    {
        $cf = new CustomFieldSelect($this->default_id, self::$default_enums);
        $value = reset(self::$default_enums);
        $enum = key(self::$default_enums);

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $enum]]], $data);
        $this->assertInternalType('integer', $data['values'][0]['value']);
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetValueThrowInvalidArgumentException()
    {
        $cf = new CustomFieldSelect($this->default_id, self::$default_enums);
        $value = 'four';

        $this->assertNotContains($value, self::$default_enums);
        $cf->setValue($value);
    }

    public function testSetEnum()
    {
        $cf = new CustomFieldSelect($this->default_id, self::$default_enums);
        $enum = key(self::$default_enums);

        $cf->setEnum($enum);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $enum]]], $data);
        $this->assertInternalType('integer', $data['values'][0]['value']);
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testSetEnumThrowInvalidArgumentException()
    {
        $cf = new CustomFieldSelect($this->default_id, self::$default_enums);
        $enum = 4;

        $this->assertFalse(isset(self::$default_enums[$enum]));
        $cf->setEnum($enum);
    }
}
