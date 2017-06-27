<?php

namespace amoCRM\Unsorted;

use amoCRM\Exceptions\RuntimeException;
use amoCRM\Exceptions\ValidateException;

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
        $this->validateSource();
        $this->validateSourceUid();
        $this->validateSourceData();
        $this->validateData();

        $result = [
            'source' => $this->getSource(),
            'source_uid' => $this->getSourceUid(),
            'source_data' => $this->getSourceData(),
            'data' => $this->getData(),
        ];

        return $result;
    }

    protected function validateSource()
    {
        $source = $this->getSource();
        if (empty($source)) {
            throw new ValidateException('Source can\'t be empty');
        }
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

    protected function validateSourceUid()
    {
        $source_uid = $this->getSourceUid();
        if (empty($source_uid)) {
            throw new ValidateException('Source Uid can\'t be empty');
        }
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

    protected function validateSourceData()
    {
        $source_data = $this->getSourceData();
        if (empty($source_data)) {
            throw new ValidateException('Source Data can\'t be empty');
        }
    }

    /**
     * @param string [$key=null]
     *
     * @return array|mixed|null
     */
    public function getSourceData($key = null)
    {
        $result = $this->_source_data;
        if (isset($key)) {
            $result = isset($result[$key]) ? $result[$key] : null;
        }

        return $result;
    }

    /**
     * @param array $source_data
     */
    public function setSourceData(array $source_data)
    {
        $this->_source_data = $source_data;
    }

    protected function validateData()
    {
        $data = $this->getData();
        if (empty($data)) {
            throw new ValidateException('Data can\'t be empty');
        }

        if (empty($data['leads'][0]['name'])) {
            throw new ValidateException('Can\'t create unsorted without at least one lead');
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array_filter($this->_data);
    }
}
