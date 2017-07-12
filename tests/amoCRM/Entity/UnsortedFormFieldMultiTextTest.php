<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseUnsortedFormField;
use amoCRM\Entity\Lead;
use amoCRM\Entity\UnsortedFormFieldMultiText;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormFieldMultiTextTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\UnsortedFormFieldMultiText
 */
final class UnsortedFormFieldMultiTextTest extends TestCase
{
    public function testInstanceOfBaseFormField()
    {
        $this->assertInstanceOf(
            BaseUnsortedFormField::class,
            new UnsortedFormFieldMultiText('test', Lead::TYPE_NUMERIC)
        );
    }

    public function testFieldType()
    {
        $field = new UnsortedFormFieldMultiText('test', Lead::TYPE_NUMERIC);
        $this->assertEquals(UnsortedFormFieldMultiText::TYPE, $field->getType());
    }

    public function testSetValue()
    {
        $field = new UnsortedFormFieldMultiText('test', Lead::TYPE_NUMERIC);
        $field->setValue('test');
        $this->assertEquals(['test'], $field->getValue());

        $field->setValue(['foo', 'bar']);
        $this->assertEquals(['test', 'foo', 'bar'], $field->getValue());
    }
}
