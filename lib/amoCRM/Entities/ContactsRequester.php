<?php

namespace amoCRM\Entities;

use amoCRM\Interfaces\Requester;

class ContactsRequester extends BaseEntityRequester
{
    public function __construct(Requester $_requester)
    {
        $names = [
            'many' => 'contacts',
        ];

        $paths = [
            'set' => 'contacts/set',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
