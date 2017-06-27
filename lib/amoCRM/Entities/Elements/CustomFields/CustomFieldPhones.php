<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldPhones
 * @package amoCRM\Entities\Elements\CustomFields
 */
final class CustomFieldPhones extends CustomFieldMultiText
{
    public function __construct($id)
    {
        $enums = [
            'WORK',
            'WORKDD',
            'MOB',
            'FAX',
            'HOME',
            'OTHER',
        ];

        parent::__construct($id, $enums);
    }
}
