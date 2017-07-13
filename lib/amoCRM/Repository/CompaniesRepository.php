<?php

namespace amoCRM\Repository;

use amoCRM\Entity\Company;
use amoCRM\Service\Interfaces\Requester;

/**
 * Class CompaniesRepository
 * @package amoCRM\Repository
 */
class CompaniesRepository extends BaseEntityRepository
{
    public function __construct(Requester $_requester)
    {
        $names = [
            'many' => Company::TYPE_MANY,
        ];

        $paths = [
            'set' => Company::TYPE_MANY.'/set',
            'list' => Company::TYPE_MANY.'/list',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
