<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\CustomFieldEmails;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldEmailsTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\CustomFieldEmails
 */
final class CustomFieldEmailsTest extends TestCase
{
    private static $enums = [
        'WORK',
        'PRIV',
        'OTHER',
    ];

    public function testDefaultEnums()
    {
        $cf = new CustomFieldEmails(1);

        $this->assertEquals(self::$enums, $cf->getEnums());
    }

    public function testGetDefaultEnum()
    {
        $cf = new CustomFieldEmails(1);
        $this->assertEquals(reset(self::$enums), $cf->getDefaultEnum());
    }
}
