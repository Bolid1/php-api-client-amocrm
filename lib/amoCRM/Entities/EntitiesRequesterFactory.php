<?php

namespace amoCRM\Entities;

use amoCRM\Exceptions\InvalidArgumentException;
use amoCRM\Interfaces\Requester;

/**
 * Class EntitiesRequesterFactory
 * @package amoCRM\Entities
 */
final class EntitiesRequesterFactory
{
    /** @var Requester */
    private $_requester;

    /**
     * RequesterFactory constructor.
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->_requester = $requester;
    }

    /**
     * @param $element_type
     * @return BaseEntityRequester
     * @throws InvalidArgumentException
     */
    public function make($element_type)
    {
        switch ($element_type) {
            case 'lead':
            case 'leads':
                $result = new LeadsRequester($this->_requester);
                break;
            case 'contact':
            case 'contacts':
                $result = new ContactsRequester($this->_requester);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Unknown element type "%s"', $element_type));
        }

        return $result;
    }
}
