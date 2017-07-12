<?php

namespace Tests\amoCRM\Unsorted\UnsortedFormFields;

use amoCRM\Entity\Lead;
use amoCRM\Unsorted\UnsortedFormFields\BaseFormField;
use amoCRM\Unsorted\UnsortedFormFields\FormFieldText;
use PHPUnit\Framework\TestCase;

/**
 * Class FormFieldTextTest
 * @package Tests\amoCRM\Unsorted\UnsortedFormFields
 * @covers \amoCRM\Unsorted\UnsortedFormFields\FormFieldText
 */
final class FormFieldTextTest extends TestCase
{
    public function testInstanceOfBaseFormField()
    {
        $this->assertInstanceOf(
            BaseFormField::class,
            new FormFieldText('test', Lead::TYPE_NUMERIC)
        );
    }

    public function testFieldType()
    {
        $field = new FormFieldText('test', Lead::TYPE_NUMERIC);
        $this->assertEquals(FormFieldText::TYPE, $field->getType());
    }
}
