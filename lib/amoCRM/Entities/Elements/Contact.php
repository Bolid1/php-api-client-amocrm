<?php

namespace amoCRM\Entities\Elements;

/**
 * Class Lead
 * @package amoCRM\Entities\Elements
 * Класс для удобной работы с полями контакта
 */
final class Contact extends BaseElement
{
    /** @var integer */
    private $_company_id;

    /** @var array<integer> */
    private $_leads_id = [];

    /**
     * @param integer $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->_company_id = $this->parseInteger($company_id);
    }

    /**
     * @param integer $lead_id
     */
    public function addLeadId($lead_id)
    {
        $this->_leads_id[] = $this->parseInteger($lead_id);
    }

    /**
     * Prepare lead for sending to amoCRM
     *
     * @return array
     */
    public function toAmo()
    {
        $contact = parent::toAmo();

        if (isset($this->_company_id)) {
            $contact['linked_company_id'] = $this->_company_id;
        }

        foreach ($this->_leads_id as $lead_id) {
            if (!isset($contact['linked_leads_id'])) {
                $contact['linked_leads_id'] = [];
            }

            $contact['linked_leads_id'][] = $lead_id;
        }

        return $contact;
    }
}
