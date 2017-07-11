<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use amoCRM\Entities\Elements\CustomFields\CustomFieldEmails;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomFieldEmailsTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldEmails
 */
final class CustomFieldEmailsTest extends TestCase
{
    private $_enums = [
        'WORK',
        'PRIV',
        'OTHER',
    ];

    public function testDefaultEnums()
    {
        $cf = new CustomFieldEmails(1);

        $this->assertEquals($this->_enums, $cf->getEnums());
    }

    public function testGetDefaultEnum()
    {
        $cf = new CustomFieldEmails(1);
        $this->assertEquals(reset($this->_enums), $cf->getDefaultEnum());
    }
}
