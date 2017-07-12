<?php

namespace amoCRM\Repository;

use amoCRM\Entity\UnsortedForm;
use amoCRM\Service\Interfaces\Requester;

/**
 * Class UnsortedFormRepository
 * Class for send requests to unsorted
 * @package amoCRM\Unsorted
 */
final class UnsortedFormRequester extends BaseUnsortedRepository implements Interfaces\UnsortedFormRepository
{
    public function __construct(Requester $requester)
    {
        parent::__construct($requester, UnsortedForm::CATEGORY);
    }
}
