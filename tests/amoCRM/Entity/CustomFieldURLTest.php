<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseCustomField;
use amoCRM\Entity\CustomFieldURL;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldURLTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldURL
 */
final class CustomFieldURLTest extends TestCase
{
    /** @var integer */
    private $default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldURL($this->default_id)
        );
    }

    public function testSetValueToAmo()
    {
        $cf = new CustomFieldURL($this->default_id);
        $value = 'my.url.com';

        $cf->setValue($value);
        $this->assertEquals(['id' => $this->default_id, 'values' => [['value' => $value]]], $cf->toAmo());
    }
}
