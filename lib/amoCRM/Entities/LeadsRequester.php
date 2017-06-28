<?php

namespace amoCRM\Entities;

use amoCRM\Entities\Elements\Lead;
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
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
