<?php

namespace amoCRM\Entities;

use amoCRM\Entity;
use amoCRM\Exceptions\InvalidArgumentException;
use amoCRM\Interfaces\Requester;

/**
 * Class EntitiesRequesterFactory
 * @package amoCRM\Entities
 */
final class EntitiesRequesterFactory
{
    /** @var Requester */
    private $requester;

    /**
     * RequesterFactory constructor.
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }

    /**
     * @param $element_type
     * @return BaseEntityRequester
     * @throws InvalidArgumentException
     */
    public function make($element_type)
    {
        switch ($element_type) {
            case Entity\Lead::TYPE_NUMERIC:
            case Entity\Lead::TYPE_SINGLE:
            case Entity\Lead::TYPE_MANY:
                $result = new LeadsRequester($this->requester);
                break;
            case Entity\Contact::TYPE_NUMERIC:
            case Entity\Contact::TYPE_SINGLE:
            case Entity\Contact::TYPE_MANY:
                $result = new ContactsRequester($this->requester);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Unknown element type "%s"', $element_type));
        }

        return $result;
    }
}
