<?php
namespace amoCRM\Unsorted;

use amoCRM\Interfaces\Requester;

final class UnsortedFormRequester extends BaseUnsortedRequester
{
    public function __construct(Requester $requester)
    {
        parent::__construct($requester, UnsortedForm::CATEGORY);
    }
}
