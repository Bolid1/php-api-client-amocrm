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
            case Elements\Lead::TYPE_NUMERIC:
            case Elements\Lead::TYPE_SINGLE:
            case Elements\Lead::TYPE_MANY:
                $result = new LeadsRequester($this->_requester);
                break;
            case Elements\Contact::TYPE_NUMERIC:
            case Elements\Contact::TYPE_SINGLE:
            case Elements\Contact::TYPE_MANY:
                $result = new ContactsRequester($this->_requester);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Unknown element type "%s"', $element_type));
        }

        return $result;
    }
}
