<?php

namespace amoCRM\Repository;

use amoCRM\Entity\UnsortedForm;
use amoCRM\Service\Interfaces\UnsortedRequesterService;

/**
 * Class UnsortedFormRepository
 * Class for send requests to unsorted
 * @package amoCRM\Unsorted
 */
final class UnsortedFormRepository extends BaseUnsortedRepository implements Interfaces\UnsortedFormRepository
{
    public function __construct(UnsortedRequesterService $requester)
    {
        parent::__construct($requester, UnsortedForm::CATEGORY);
    }
}
