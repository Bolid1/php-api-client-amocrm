<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldPhones
 * @package amoCRM\Entity
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
