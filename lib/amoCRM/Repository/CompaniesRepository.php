<?php

namespace amoCRM\Repository;

use amoCRM\Entity\Company;
use amoCRM\Service\Interfaces\RequesterService;

/**
 * Class CompaniesRepository
 * @package amoCRM\Repository
 */
class CompaniesRepository extends BaseEntityRepository
{
    public function __construct(RequesterService $_requester)
    {
        $names = [
            'many' => Company::TYPE_MANY,
        ];

        $paths = [
            'set' => Company::TYPE_SINGLE.'/set',
            'list' => Company::TYPE_MANY.'/list',
        ];

        parent::__construct($_requester, $names, $paths);
    }
}
