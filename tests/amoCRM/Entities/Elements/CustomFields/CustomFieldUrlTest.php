<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\BaseCustomField;
use amoCRM\Entities\Elements\CustomFields\CustomFieldUrl;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldUrlTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldUrl
 */
class CustomFieldUrlTest extends TestCase
{
    /** @var integer */
    private $_default_id = 25;

    public function testIsInstanceOfBaseField()
    {
        $this->assertInstanceOf(
            BaseCustomField::class,
            new CustomFieldUrl($this->_default_id)
        );
    }

    public function testSetValueToAmo()
    {
        $cf = new CustomFieldUrl($this->_default_id);
        $value = 'my.url.com';

        $cf->setValue($value);
        $this->assertEquals(['id' => $this->_default_id, 'values' => [['value' => $value]]], $cf->toAmo());
    }
}
