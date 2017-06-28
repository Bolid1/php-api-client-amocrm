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
    /** @var integer */
    private $_default_id = 25;
    private $_default_enums = [
        'WORK',
        'OTHER',
    ];

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
            ->setConstructorArgs([$this->_default_id, $this->_default_enums])
            ->setMethods(null)
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

        $this->assertNotContains($enum, $this->_default_enums);
        $cf->addValue($enum, 'some text');
    }

    public function testAddValue()
    {
        $cf = $this->buildMock();

        // Add first value
        $enum = reset($this->_default_enums);
        $value = 'some text';
        $cf->addValue($enum, $value);
        $values = [['enum' => $enum, 'value' => $value]];
        $this->assertEquals(['id' => $this->_default_id, 'values' => $values], $cf->toAmo());

        // Add value with another code
        $enum = next($this->_default_enums);
        $value = 'another text';
        $cf->addValue($enum, $value);
        $values[] = ['enum' => $enum, 'value' => $value];
        $this->assertEquals(['id' => $this->_default_id, 'values' => $values], $cf->toAmo());
    }

    public function testAddValueWithSameCode()
    {
        $cf = $this->buildMock();

        $enum = reset($this->_default_enums);
        $values = [];
        for ($i = 0; $i < 2; ++$i) {
            $value = 'another text';
            $cf->addValue($enum, $value);
            $values[] = ['enum' => $enum, 'value' => $value];
        }

        $this->assertEquals(['id' => $this->_default_id, 'values' => $values], $cf->toAmo());
    }

    public function testGetEnums()
    {
        $this->assertEquals($this->_default_enums, $this->buildMock()->getEnums());
    }

    public function testGetDefaultEnum()
    {
        $this->assertEquals(reset($this->_default_enums), $this->buildMock()->getDefaultEnum());
    }
}
