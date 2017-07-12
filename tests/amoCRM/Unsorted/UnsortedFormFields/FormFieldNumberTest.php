<?php

namespace Tests\amoCRM\Unsorted\UnsortedFormFields;

use amoCRM\Entity\Lead;
use amoCRM\Unsorted\UnsortedFormFields\BaseFormField;
use amoCRM\Unsorted\UnsortedFormFields\FormFieldNumber;
use PHPUnit\Framework\TestCase;

/**
 * Class FormFieldNumberTest
 * @package Tests\amoCRM\Unsorted\UnsortedFormFields
 * @covers \amoCRM\Unsorted\UnsortedFormFields\FormFieldNumber
 */
final class FormFieldNumberTest extends TestCase
{
    public function testInstanceOfBaseFormField()
    {
        $this->assertInstanceOf(
            BaseFormField::class,
            new FormFieldNumber('test', Lead::TYPE_NUMERIC)
        );
    }

    public function testFieldType()
    {
        $field = new FormFieldNumber('test', Lead::TYPE_NUMERIC);
        $this->assertEquals(FormFieldNumber::TYPE, $field->getType());
    }
}
