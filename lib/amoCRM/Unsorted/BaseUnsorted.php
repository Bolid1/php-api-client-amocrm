<?php

namespace amoCRM\Unsorted;

use amoCRM\Exceptions\RuntimeException;

abstract class BaseUnsorted
{
    /** @var string */
    private $_source;
    /** @var string */
    private $_source_uid;
    /** @var array */
    private $_source_data;
    /** @var array */
    private $_data = [
        'leads' => [],
        'contacts' => [],
        'companies' => [],
    ];

    /**
     * @param array $lead
     */
    public function addLead(array $lead)
    {
        $this->_data['leads'][] = $lead;
    }

    /**
     * @param array $contact
     */
    public function addContact(array $contact)
    {
        $this->_data['contacts'][] = $contact;
    }

    /**
     * @param array $company
     */
    public function addCompany(array $company)
    {
        $this->_data['companies'][] = $company;
    }

    /**
     * Prepare current unsorted element for send to amoCRM
     * @return array
     * @throws RuntimeException
     */
    public function toAmo()
    {

        $result = [
            'source' => $this->getSource(),
            'source_uid' => $this->getSourceUid(),
            'source_data' => $this->getSourceData(),
            'data' => $this->getData(),
        ];

        if (empty($result['data']['leads'][0]['name'])) {
            throw new RuntimeException('Can\'t create unsorted without at least one lead');
        }

        foreach ($result as $key => $value) {
            if (empty($value)) {
                throw new RuntimeException(sprintf('Key "%s" must be not empty', $key));
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->_source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->_source = $source;
    }

    /**
     * @return string
     */
    public function getSourceUid()
    {
        return $this->_source_uid;
    }

    /**
     * @param string $source_uid
     */
    public function setSourceUid($source_uid)
    {
        $this->_source_uid = $source_uid;
    }

    /**
     * @return array
     */
    public function getSourceData()
    {
        return $this->_source_data;
    }

    /**
     * @param array $source_data
     */
    public function setSourceData(array $source_data)
    {
        $this->_source_data = $source_data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array_filter($this->_data);
    }
}
