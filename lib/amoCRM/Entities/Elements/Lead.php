<?php

namespace amoCRM\Entities\Elements;

/**
 * Class Lead
 * @package amoCRM\Entities\Elements
 * Класс для удобной работы с полями сделки
 */
final class Lead extends BaseElement
{
    const TYPE_NUMERIC = 2;
    const TYPE_SINGLE = 'lead';
    const TYPE_MANY = 'leads';

    /** @var integer */
    private $_price;

    /** @var integer */
    private $_status_id;
    /** @var integer */
    private $_pipeline_id;

    /** @var integer */
    private $_company_id;
    /** @var string */
    private $_visitor_uid;

    /**
     * @param integer $price
     */
    public function setPrice($price)
    {
        $price = $this->parseInteger($price, true);
        $this->_price = $price > 0 ? $price : 0;
    }

    /**
     * @param integer $status_id
     */
    public function setStatusId($status_id)
    {
        $this->_status_id = $this->parseInteger($status_id);
    }

    /**
     * @param integer $pipeline_id
     */
    public function setPipelineId($pipeline_id)
    {
        $this->_pipeline_id = $this->parseInteger($pipeline_id);
    }

    /**
     * @param integer $linked_company_id
     */
    public function setCompanyId($linked_company_id)
    {
        $this->_company_id = $this->parseInteger($linked_company_id);
    }

    /**
     * @param string $visitor_uid
     */
    public function setVisitorUid($visitor_uid)
    {
        $this->_visitor_uid = (string)$visitor_uid;
    }

    /**
     * Prepare lead for sending to amoCRM
     *
     * @return array
     */
    public function toAmo()
    {
        $lead = parent::toAmo();

        if (isset($this->_price)) {
            $lead['price'] = $this->_price;
        }
        if (isset($this->_status_id)) {
            $lead['status_id'] = $this->_status_id;
        }
        if (isset($this->_pipeline_id)) {
            $lead['pipeline_id'] = $this->_pipeline_id;
        }
        if (isset($this->_company_id)) {
            $lead['linked_company_id'] = $this->_company_id;
        }
        if (isset($this->_visitor_uid)) {
            $lead['visitor_uid'] = $this->_visitor_uid;
        }

        return $lead;
    }
}
