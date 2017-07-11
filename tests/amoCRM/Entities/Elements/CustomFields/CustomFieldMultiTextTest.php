<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\BaseCustomField;
use amoCRM\Entities\Elements\CustomFields\CustomFieldMultiText;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldMultiTextTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldMultiText
 */
class CustomFieldMultiTextTest extends TestCase
{
    private static $default_enums = [
        'WORK',
        'OTHER',
    ];
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            $this->buildMock()
        );
    }

    /**
     * @return CustomFieldMultiText
     */
    private function buildMock()
    {
        $stub = $this->getMockBuilder(CustomFieldMultiText::class)
            ->setConstructorArgs([$this->default_id, self::$default_enums])
            ->setMethods()
            ->getMock();

        /** @var CustomFieldMultiText $stub */
        return $stub;
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testAddValueThrowInvalidArgumentException()
    {
        $cf = $this->buildMock();
        $enum = 'HOME';

        $this->assertNotContains($enum, self::$default_enums);
        $cf->addValue($enum, 'some text');
    }

    public function testAddValue()
    {
        $cf = $this->buildMock();

        // Add first value
        $enum = reset(self::$default_enums);
        $value = 'some text';
        $cf->addValue($enum, $value);
        $values = [['enum' => $enum, 'value' => $value]];
        $this->assertEquals(['id' => $this->default_id, 'values' => $values], $cf->toAmo());

        // Add value with another code
        $enum = next(self::$default_enums);
        $value = 'another text';
        $cf->addValue($enum, $value);
        $values[] = ['enum' => $enum, 'value' => $value];
        $this->assertEquals(['id' => $this->default_id, 'values' => $values], $cf->toAmo());
    }

    public function testAddValueWithSameCode()
    {
        $cf = $this->buildMock();

        $enum = reset(self::$default_enums);
        $values = [];
        for ($i = 0; $i < 2; ++$i) {
            $value = 'another text';
            $cf->addValue($enum, $value);
            $values[] = ['enum' => $enum, 'value' => $value];
        }

        $this->assertEquals(['id' => $this->default_id, 'values' => $values], $cf->toAmo());
    }

    public function testGetEnums()
    {
        $this->assertEquals(self::$default_enums, $this->buildMock()->getEnums());
    }

    public function testGetDefaultEnum()
    {
        $this->assertEquals(reset(self::$default_enums), $this->buildMock()->getDefaultEnum());
    }
}
