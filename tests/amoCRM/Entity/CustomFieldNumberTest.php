<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\CustomFieldNumber;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldNumberTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldNumber
 */
final class CustomFieldNumberTest extends TestCase
{
    /** @var integer */
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldNumber($this->default_id)
        );
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetValueToAmoThrowInvalidArgumentNaN()
    {
        $cf = new CustomFieldNumber($this->default_id);
        $value = 'some text';

        $cf->setValue($value);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetValueToAmoThrowInvalidArgumentPositive()
    {
        $cf = new CustomFieldNumber($this->default_id);
        $value = -1;

        $cf->setValue($value);
    }

    public function testSetValueToInteger()
    {
        $cf = new CustomFieldNumber($this->default_id);
        $value = 12;

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
        $this->assertInternalType('integer', $data['values'][0]['value']);
    }
}
