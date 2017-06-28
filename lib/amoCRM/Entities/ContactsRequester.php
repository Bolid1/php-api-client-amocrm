<?php

namespace amoCRM\Entities;

use amoCRM\Entities\Elements\Contact;
use amoCRM\Interfaces\Requester;

class ContactsRequester extends BaseEntityRequester
{
    public function __construct(Requester $_requester)
    {
        $names = [
            'many' => Contact::TYPE_MANY,
        ];

        $paths = [
            'set' => Contact::TYPE_MANY . '/set',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
