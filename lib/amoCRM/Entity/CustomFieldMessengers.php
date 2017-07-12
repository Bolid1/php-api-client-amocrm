<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldMessengers
 * @package amoCRM\Entity
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
