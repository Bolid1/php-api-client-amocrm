<?php

namespace Tests\amoCRM\Unsorted\UnsortedFormFields;

use amoCRM\Entity\Lead;
use amoCRM\Unsorted\UnsortedFormFields\BaseFormField;
use amoCRM\Unsorted\UnsortedFormFields\FormFieldMultiText;
use PHPUnit\Framework\TestCase;

/**
 * Class FormFieldMultiTextTest
 * @package Tests\amoCRM\Unsorted\UnsortedFormFields
 * @covers \amoCRM\Unsorted\UnsortedFormFields\FormFieldMultiText
 */
final class FormFieldMultiTextTest extends TestCase
{
    public function testInstanceOfBaseFormField()
    {
        $this->assertInstanceOf(
            BaseFormField::class,
            new FormFieldMultiText('test', Lead::TYPE_NUMERIC)
        );
    }

    public function testFieldType()
    {
        $field = new FormFieldMultiText('test', Lead::TYPE_NUMERIC);
        $this->assertEquals(FormFieldMultiText::TYPE, $field->getType());
    }

    public function testSetValue()
    {
        $field = new FormFieldMultiText('test', Lead::TYPE_NUMERIC);
        $field->setValue('test');
        $this->assertEquals(['test'], $field->getValue());

        $field->setValue(['foo', 'bar']);
        $this->assertEquals(['test', 'foo', 'bar'], $field->getValue());
    }
}
