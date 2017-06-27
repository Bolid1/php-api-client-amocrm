<?php

namespace amoCRM\Entities\Elements\CustomFields;

/**
 * Class CustomFieldEmails
 * @package amoCRM\Entities\Elements\CustomFields
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
