<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldMessengers
 * @package amoCRM\Entities\Elements\CustomFields
 */
final class CustomFieldMessengers extends CustomFieldMultiText
{
    public function __construct($id)
    {
        $enums = [
            'JABBER',
            'SKYPE',
            'GTALK',
            'MSN',
            'OTHER',
            'ICQ',
        ];

        parent::__construct($id, $enums);
    }
}
