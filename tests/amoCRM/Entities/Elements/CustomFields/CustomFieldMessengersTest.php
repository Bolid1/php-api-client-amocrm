<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use PHPUnit\Framework\TestCase;
use amoCRM\Entities\Elements\CustomFields\CustomFieldMessengers;

/**
 * Class CustomFieldMessengersTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldMessengers
 */
final class CustomFieldMessengersTest extends TestCase
{
    private $_enums = [
        'JABBER',
        'SKYPE',
        'GTALK',
        'MSN',
        'OTHER',
        'ICQ',
    ];

    public function testDefaultEnums() {
        $cf = new CustomFieldMessengers(1);

        $this->assertEquals($this->_enums, $cf->getEnums());
    }

    public function testGetDefaultEnum() {
        $cf = new CustomFieldMessengers(1);
        $this->assertEquals(reset($this->_enums), $cf->getDefaultEnum());
    }
}
