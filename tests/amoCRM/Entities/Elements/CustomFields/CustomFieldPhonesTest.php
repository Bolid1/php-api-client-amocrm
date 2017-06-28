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
    public function testDefaultEnums() {
        $cf = new CustomFieldPhones(1);

        $enums = [
            'WORK',
            'WORKDD',
            'MOB',
            'FAX',
            'HOME',
            'OTHER',
        ];
        $this->assertEquals($enums, $cf->getEnums());
    }
}
