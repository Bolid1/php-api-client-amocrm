<?php

namespace amoCRM\Entities;

use amoCRM\Interfaces\Requester;

class LeadsRequester extends BaseEntityRequester
{
    public function __construct(Requester $_requester)
    {
        $names = [
            'many' => 'leads',
        ];

        $paths = [
            'set' => 'leads/set',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
