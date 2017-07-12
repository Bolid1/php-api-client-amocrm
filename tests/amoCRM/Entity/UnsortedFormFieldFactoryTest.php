<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\Factory\FormFieldFactory;
use amoCRM\Entity\Lead;
use amoCRM\Entity\UnsortedFormFieldMultiText;
use amoCRM\Entity\UnsortedFormFieldNumber;
use amoCRM\Entity\UnsortedFormFieldText;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormFieldFactoryTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\Factory\FormFieldFactory
 */
final class UnsortedFormFieldFactoryTest extends TestCase
{
    public function testMakeText()
    {
        $this->assertInstanceOf(
            UnsortedFormFieldText::class,
            FormFieldFactory::make(
                UnsortedFormFieldText::TYPE,
                'test',
                Lead::TYPE_NUMERIC
            )
        );
    }

    public function testMakeNumber()
    {
        $this->assertInstanceOf(
            UnsortedFormFieldNumber::class,
            FormFieldFactory::make(
                UnsortedFormFieldNumber::TYPE,
                'test',
                Lead::TYPE_NUMERIC
            )
        );
    }

    public function testMakeMultiText()
    {
        $this->assertInstanceOf(
            UnsortedFormFieldMultiText::class,
            FormFieldFactory::make(
                UnsortedFormFieldMultiText::TYPE,
                'test',
                Lead::TYPE_NUMERIC
            )
        );
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     * @expectedExceptionMessage Unknown field type "test"
     */
    public function testMakeThrowInvalidArgumentException()
    {
        FormFieldFactory::make('test', 'test', Lead::TYPE_NUMERIC);
    }
}
