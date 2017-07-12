<?php

namespace amoCRM\Entities;

use amoCRM\Entity\Lead;
use amoCRM\Interfaces\Requester;

class LeadsRequester extends BaseEntityRequester
{
    public function __construct(Requester $_requester)
    {
        $names = [
            'many' => Lead::TYPE_MANY,
        ];

        $paths = [
            'set' => Lead::TYPE_MANY . '/set',
            'list' => Lead::TYPE_MANY . '/list',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
