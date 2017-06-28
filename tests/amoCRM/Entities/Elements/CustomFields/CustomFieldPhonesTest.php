<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use PHPUnit\Framework\TestCase;
use amoCRM\Entities\Elements\CustomFields\CustomFieldPhones;

/**
 * Class CustomFieldPhonesTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldPhones
 */
final class CustomFieldPhonesTest extends TestCase
{
    private $_enums = [
        'WORK',
        'WORKDD',
        'MOB',
        'FAX',
        'HOME',
        'OTHER',
    ];

    public function testDefaultEnums() {
        $cf = new CustomFieldPhones(1);

        $this->assertEquals($this->_enums, $cf->getEnums());
    }

    public function testGetDefaultEnum() {
        $cf = new CustomFieldPhones(1);
        $this->assertEquals(reset($this->_enums), $cf->getDefaultEnum());
    }
}
