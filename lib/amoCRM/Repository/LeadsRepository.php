<?php

namespace amoCRM\Repository;

use amoCRM\Entity\Lead;
use amoCRM\Service\Interfaces\Requester;

class LeadsRepository extends BaseEntityRepository
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
