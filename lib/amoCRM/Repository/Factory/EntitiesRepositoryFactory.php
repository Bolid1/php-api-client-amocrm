<?php

namespace amoCRM\Repository\Factory;

use amoCRM\Entity;
use amoCRM\Exception\InvalidArgumentException;
use amoCRM\Repository\ContactsRepository;
use amoCRM\Repository\LeadsRepository;
use amoCRM\Service\Interfaces\Requester;

/**
 * Class EntitiesRequesterFactory
 * @package amoCRM\Entities
 */
final class EntitiesRepositoryFactory
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
     * @param string|integer $element_type
     * @return ContactsRepository|LeadsRepository
     * @throws InvalidArgumentException
     */
    public function make($element_type)
    {
        switch ($element_type) {
            case Entity\Lead::TYPE_NUMERIC:
            case Entity\Lead::TYPE_SINGLE:
            case Entity\Lead::TYPE_MANY:
                $result = new LeadsRepository($this->requester);
                break;
            case Entity\Contact::TYPE_NUMERIC:
            case Entity\Contact::TYPE_SINGLE:
            case Entity\Contact::TYPE_MANY:
                $result = new ContactsRepository($this->requester);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Unknown element type "%s"', $element_type));
        }

        return $result;
    }
}
