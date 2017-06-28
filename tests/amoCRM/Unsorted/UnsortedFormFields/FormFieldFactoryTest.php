<?php

namespace Tests\amoCRM\Unsorted\UnsortedFormFields;

use amoCRM\Entities\Elements\Lead;
use PHPUnit\Framework\TestCase;
use amoCRM\Unsorted\UnsortedFormFields;

/**
 * Class FormFieldFactoryTest
 * @package Tests\amoCRM\Unsorted\UnsortedFormFields
 * @covers \amoCRM\Unsorted\UnsortedFormFields\FormFieldFactory
 */
final class FormFieldFactoryTest extends TestCase
{
    public function testMakeText()
    {
        $this->assertInstanceOf(
            UnsortedFormFields\FormFieldText::class,
            UnsortedFormFields\FormFieldFactory::make(
                UnsortedFormFields\FormFieldText::TYPE,
                'test',
                Lead::TYPE_NUMERIC
            )
        );
    }

    public function testMakeNumber()
    {
        $this->assertInstanceOf(
            UnsortedFormFields\FormFieldNumber::class,
            UnsortedFormFields\FormFieldFactory::make(
                UnsortedFormFields\FormFieldNumber::TYPE,
                'test',
                Lead::TYPE_NUMERIC
            )
        );
    }

    public function testMakeMultiText()
    {
        $this->assertInstanceOf(
            UnsortedFormFields\FormFieldMultiText::class,
            UnsortedFormFields\FormFieldFactory::make(
                UnsortedFormFields\FormFieldMultiText::TYPE,
                'test',
                Lead::TYPE_NUMERIC
            )
        );
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Unknown field type "test"
     */
    public function testMakeThrowInvalidArgumentException()
    {
        UnsortedFormFields\FormFieldFactory::make('test','test',Lead::TYPE_NUMERIC);
    }
}
