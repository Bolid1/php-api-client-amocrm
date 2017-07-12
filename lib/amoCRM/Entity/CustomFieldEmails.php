<?php

namespace amoCRM\Entity;

/**
 * Class CustomFieldEmails
 * @package amoCRM\Entity
 */
final class CustomFieldEmails extends CustomFieldMultiText
{
    public function __construct($id)
    {
        $enums = [
            'WORK',
            'PRIV',
            'OTHER',
        ];

        parent::__construct($id, $enums);
    }
}
