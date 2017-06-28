<?php

namespace Tests\amoCRM\Unsorted\UnsortedFormFields;

use PHPUnit\Framework\TestCase;
use amoCRM\Entities\Elements\Lead;
use amoCRM\Unsorted\UnsortedFormFields\BaseFormField;
use amoCRM\Unsorted\UnsortedFormFields\FormFieldMultiText;

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
}