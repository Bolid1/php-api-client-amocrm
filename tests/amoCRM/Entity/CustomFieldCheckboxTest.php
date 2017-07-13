<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\CustomFieldCheckbox;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldCheckboxTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldCheckbox
 */
final class CustomFieldCheckboxTest extends TestCase
{
    /** @var integer */
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldCheckbox($this->default_id)
        );
    }

    public function testSetValueTrue()
    {
        $this->checkSetValue(1);
    }

    /**
     * @param integer $value
     */
    private function checkSetValue($value)
    {
        $cf = new CustomFieldCheckbox($this->default_id);

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
        $this->assertInternalType('integer', $data['values'][0]['value']);
    }

    public function testSetValueFalse()
    {
        $this->checkSetValue(0);
    }
}
