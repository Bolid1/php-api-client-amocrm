<?php

namespace amoCRM\Entity;

/**
 * Class Lead
 * @package amoCRM\Entity
 * Класс для удобной работы с полями сделки
 */
final class Lead extends BaseElement
{
    const TYPE_NUMERIC = 2;
    const TYPE_SINGLE = 'lead';
    const TYPE_MANY = 'leads';

    /** @var integer */
    private $price;

    /** @var integer */
    private $status_id;
    /** @var integer */
    private $pipeline_id;

    /** @var integer */
    private $company_id;
    /** @var string */
    private $visitor_uid;

    /**
     * Prepare lead for sending to amoCRM
     *
     * @return array
     */
    public function toAmo()
    {
        $lead = parent::toAmo();

        if ($this->price !== null) {
            $lead['price'] = $this->price;
        }
        if ($this->status_id !== null) {
            $lead['status_id'] = $this->status_id;
        }
        if ($this->pipeline_id !== null) {
            $lead['pipeline_id'] = $this->pipeline_id;
        }
        if ($this->company_id !== null) {
            $lead['linked_company_id'] = $this->company_id;
        }
        if ($this->visitor_uid !== null) {
            $lead['visitor_uid'] = $this->visitor_uid;
        }

        return $lead;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param integer $price
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function setPrice($price)
    {
        $price = $this->parseInteger($price, true);
        $this->price = $price > 0 ? $price : 0;
    }

    /**
     * @return int
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param integer $status_id
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $this->parseInteger($status_id);
    }

    /**
     * @return int
     */
    public function getPipelineId()
    {
        return $this->pipeline_id;
    }

    /**
     * @param integer $pipeline_id
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function setPipelineId($pipeline_id)
    {
        $this->pipeline_id = $this->parseInteger($pipeline_id);
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param integer $linked_company_id
     * @throws \amoCRM\Exception\InvalidArgumentException
     */
    public function setCompanyId($linked_company_id)
    {
        $this->company_id = $this->parseInteger($linked_company_id);
    }

    /**
     * @return string
     */
    public function getVisitorUid()
    {
        return $this->visitor_uid;
    }

    /**
     * @param string $visitor_uid
     */
    public function setVisitorUid($visitor_uid)
    {
        $this->visitor_uid = (string)$visitor_uid;
    }
}
