<?php

namespace Tests\amoCRM\Entities\Elements\CustomFields;

use PHPUnit\Framework\TestCase;
use amoCRM\Entities\Elements\CustomFields\CustomFieldEmails;

/**
 * Class CustomFieldEmailsTest
 * @package Tests\amoCRM\Entities\Elements\CustomFields
 * @covers \amoCRM\Entities\Elements\CustomFields\CustomFieldEmails
 */
final class CustomFieldEmailsTest extends TestCase
{
    public function testDefaultEnums() {
        $cf = new CustomFieldEmails(1);

        $enums = [
            'WORK',
            'PRIV',
            'OTHER',
        ];
        $this->assertEquals($enums, $cf->getEnums());
    }
}
