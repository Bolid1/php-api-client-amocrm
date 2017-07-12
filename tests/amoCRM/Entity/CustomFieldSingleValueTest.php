<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\CustomFieldSingleValue;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldSingleValueTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldSingleValue
 */
final class CustomFieldSingleValueTest extends TestCase
{
    public function testValueToAmo()
    {
        $field = $this->getMockBuilder(CustomFieldSingleValue::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        $value = 'test';
        $field->setValue($value);

        $expected = ['id' => null, 'values' => [['value' => $value]]];
        $this->assertEquals($value, $field->getValue());
        $this->assertEquals($expected, $field->toAmo());
    }
}
