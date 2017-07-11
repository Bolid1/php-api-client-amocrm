<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\CustomFieldSingleValue;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldSingleValueTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldSingleValue
 */
final class CustomFieldSingleValueTest extends TestCase
{
    public function testValueToAmo()
    {
        $field = $this->getMockBuilder(CustomFieldSingleValue::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        $field->setValue('test');

        $expected = ['id' => null, 'values' => [['value' => 'test']]];
        $this->assertEquals($expected, $field->toAmo());
    }
}
