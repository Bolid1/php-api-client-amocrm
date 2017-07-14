<?php

namespace amoCRM\Entity;

use amoCRM\Parser\NumberParser;

/**
 * Class Lead
 * @package amoCRM\Entity
 * Класс для удобной работы с полями контакта
 */
final class Contact extends BaseElement
{
    const TYPE_NUMERIC = 1;
    const TYPE_SINGLE = 'contact';
    const TYPE_MANY = 'contacts';

    /** @var integer */
    private $company_id;

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

        if ($this->company_id !== null) {
            $contact['linked_company_id'] = $this->company_id;
        }

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

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param integer $company_id
     * @throws \amoCRM\Exception\ValidateException
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = NumberParser::parseInteger($company_id);
    }
}
