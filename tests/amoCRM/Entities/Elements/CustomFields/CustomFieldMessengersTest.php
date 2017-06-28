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
    public function testDefaultEnums() {
        $cf = new CustomFieldMessengers(1);

        $enums = [
            'JABBER',
            'SKYPE',
            'GTALK',
            'MSN',
            'OTHER',
            'ICQ',
        ];
        $this->assertEquals($enums, $cf->getEnums());
    }
}
