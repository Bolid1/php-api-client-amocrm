<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseUnsortedFormField;
use amoCRM\Entity\Lead;
use amoCRM\Entity\UnsortedFormFieldText;
use PHPUnit\Framework\TestCase;

/**
 * Class FormFieldTextTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\UnsortedFormFieldText
 */
final class UnsortedFormFieldTextTest extends TestCase
{
    public function testInstanceOfBaseFormField()
    {
        $this->assertInstanceOf(
            BaseUnsortedFormField::class,
            new UnsortedFormFieldText('test', Lead::TYPE_NUMERIC)
        );
    }

    public function testFieldType()
    {
        $field = new UnsortedFormFieldText('test', Lead::TYPE_NUMERIC);
        $this->assertEquals(UnsortedFormFieldText::TYPE, $field->getType());
    }
}
