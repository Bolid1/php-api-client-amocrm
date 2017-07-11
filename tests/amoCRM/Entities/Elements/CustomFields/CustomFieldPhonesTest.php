<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\CustomFieldPhones;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldPhonesTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldPhones
 */
final class CustomFieldPhonesTest extends TestCase
{
    private static $enums = [
        'WORK',
        'WORKDD',
        'MOB',
        'FAX',
        'HOME',
        'OTHER',
    ];

    public function testDefaultEnums()
    {
        $cf = new CustomFieldPhones(1);

        $this->assertEquals(self::$enums, $cf->getEnums());
    }

    public function testGetDefaultEnum()
    {
        $cf = new CustomFieldPhones(1);
        $this->assertEquals(reset(self::$enums), $cf->getDefaultEnum());
    }
}
