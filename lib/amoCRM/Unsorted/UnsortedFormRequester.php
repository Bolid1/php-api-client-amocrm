<?php

namespace amoCRM\Unsorted;

use amoCRM\Interfaces\Requester;

/**
 * Class UnsortedFormRequester
 * Class for send requests to unsorted
 * @package amoCRM\Unsorted
 */
final class UnsortedFormRequester extends BaseUnsortedRequester implements Interfaces\UnsortedFormRequester
{
    public function __construct(Requester $requester)
    {
        parent::__construct($requester, UnsortedForm::CATEGORY);
    }
}
