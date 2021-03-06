<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\CustomFieldAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldAddressTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldAddress
 */
final class CustomFieldAddressTest extends TestCase
{
    /** @var integer */
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldAddress($this->default_id)
        );
    }

    public function testSetValueToAmo()
    {
        $cf = new CustomFieldAddress($this->default_id);
        $value = sprintf("%s\n%s\n%s", 'some', 'multi line', 'text');

        $cf->setValue($value);
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $cf->toAmo());
    }

    public function testSetValue()
    {
        $cf = new CustomFieldAddress($this->default_id);
        $value = 1;

        $cf->setValue($value);

        $data = $cf->toAmo();
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $data);
        $this->assertInternalType('string', $data['values'][0]['value']);
    }
}
