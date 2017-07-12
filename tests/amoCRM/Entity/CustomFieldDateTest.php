<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\CustomFieldDate;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldDateTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldDate
 */
final class CustomFieldDateTest extends TestCase
{
    /** @var integer */
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldDate($this->default_id)
        );
    }

    public function getDateFormat()
    {
        $cf = new CustomFieldDate($this->default_id);
        $this->assertEquals('d.m.Y', $cf->getDateFormat());
    }

    public function testSetPositiveTimestamp()
    {
        $cf = new CustomFieldDate($this->default_id);
        $timestamp = time();
        $value = date($cf->getDateFormat(), $timestamp);

        $cf->setTimestamp($timestamp);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
    }

    public function testSetNegativeTimestamp()
    {
        $cf = new CustomFieldDate($this->default_id);
        $timestamp = -time();
        $value = date($cf->getDateFormat(), $timestamp);

        $cf->setTimestamp($timestamp);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetValueToAmoThrowInvalidArgumentNotADate()
    {
        $cf = new CustomFieldDate($this->default_id);
        $value = 'some text';

        $cf->setValue($value);
    }

    public function testSetValue()
    {
        $cf = new CustomFieldDate($this->default_id);
        $value = date($cf->getDateFormat(), time());

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
    }
}
