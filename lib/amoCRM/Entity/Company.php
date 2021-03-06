<?php

namespace amoCRM\Entity;

use amoCRM\Parser\NumberParser;

/**
 * Class Lead
 * @package amoCRM\Entity
 * Класс для удобной работы с полями компании
 */
final class Company extends BaseElement
{
    const TYPE_NUMERIC = 3;
    const TYPE_SINGLE = 'company';
    const TYPE_MANY = 'companies';

    /** @var array<integer> */
    private $leads_id = [];

    /**
     * @param integer $lead_id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function addLeadId($lead_id)
    {
        $this->leads_id[] = NumberParser::parseInteger($lead_id);
    }

    /**
     * Prepare lead for sending to amoCRM
     *
     * @return array
     */
    public function toAmo()
    {
        $contact = parent::toAmo();

        foreach ($this->leads_id as $lead_id) {
            if (!isset($contact['linked_leads_id'])) {
                $contact['linked_leads_id'] = [];
            }

            $contact['linked_leads_id'][] = $lead_id;
        }

        return $contact;
    }

    /**
     * @return array
     */
    public function getLeadsId()
    {
        return $this->leads_id;
    }

    /**
     * @param array $leads_id
     */
    public function setLeadsId(array $leads_id)
    {
        $this->leads_id = [];
        array_map([$this, 'addLeadId'], $leads_id);
    }
}
