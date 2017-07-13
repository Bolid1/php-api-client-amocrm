<?php

namespace amoCRM\Repository;

use amoCRM\Entity\Lead;
use amoCRM\Service\Interfaces\RequesterService;

/**
 * Class LeadsRepository
 * @package amoCRM\Repository
 */
class LeadsRepository extends BaseEntityRepository
{
    public function __construct(RequesterService $_requester)
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
