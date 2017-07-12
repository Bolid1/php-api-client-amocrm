<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\CustomFieldMessengers;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldMessengersTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldMessengers
 */
final class CustomFieldMessengersTest extends TestCase
{
    private static $enums = [
        'JABBER',
        'SKYPE',
        'GTALK',
        'MSN',
        'OTHER',
        'ICQ',
    ];

    public function testDefaultEnums()
    {
        $cf = new CustomFieldMessengers(1);

        $this->assertEquals(self::$enums, $cf->getEnums());
    }

    public function testGetDefaultEnum()
    {
        $cf = new CustomFieldMessengers(1);
        $this->assertEquals(reset(self::$enums), $cf->getDefaultEnum());
    }
}
