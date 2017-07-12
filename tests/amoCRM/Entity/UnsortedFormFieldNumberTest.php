<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseUnsortedFormField;
use amoCRM\Entity\Lead;
use amoCRM\Entity\UnsortedFormFieldNumber;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormFieldNumberTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\UnsortedFormFieldNumber
 */
final class UnsortedFormFieldNumberTest extends TestCase
{
    public function testInstanceOfBaseFormField()
    {
        $this->assertInstanceOf(
            BaseUnsortedFormField::class,
            new UnsortedFormFieldNumber('test', Lead::TYPE_NUMERIC)
        );
    }

    public function testFieldType()
    {
        $field = new UnsortedFormFieldNumber('test', Lead::TYPE_NUMERIC);
        $this->assertEquals(UnsortedFormFieldNumber::TYPE, $field->getType());
    }
}
