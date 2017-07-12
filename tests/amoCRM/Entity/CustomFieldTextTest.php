<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\CustomFieldText;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldTextTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldText
 */
final class CustomFieldTextTest extends TestCase
{
    /** @var integer */
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldText($this->default_id)
        );
    }

    public function testSetValueToAmo()
    {
        $cf = new CustomFieldText($this->default_id);
        $value = 'some text';

        $cf->setValue($value);
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $cf->toAmo());
    }

    public function testSetValue()
    {
        $cf = new CustomFieldText($this->default_id);
        $value = 1;

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
        $this->assertInternalType('string', $data['values'][0]['value']);
    }
}
