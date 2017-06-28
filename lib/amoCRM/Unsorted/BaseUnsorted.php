<?php

namespace amoCRM\Unsorted;

use amoCRM\Entities\Elements;
use amoCRM\Exceptions\RuntimeException;
use amoCRM\Exceptions\ValidateException;

/**
 * Class BaseUnsorted
 * @package amoCRM\Unsorted
 */
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
        Elements\Lead::TYPE_MANY => [],
        Elements\Contact::TYPE_MANY => [],
        'companies' => [],
    ];

    /**
     * @param array $lead
     */
    public function addLead(array $lead)
    {
        $this->_data[Elements\Lead::TYPE_MANY][] = $lead;
    }

    /**
     * @param array $contact
     */
    public function addContact(array $contact)
    {
        $this->_data[Elements\Contact::TYPE_MANY][] = $contact;
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
            'source' => $this->getSourceToAmo(),
            'source_uid' => $this->getSourceUidToAmo(),
            'source_data' => $this->getSourceDataToAmo(),
            'data' => $this->getDataToAmo(),
        ];

        $this->validateSource($result['source']);
        $this->validateSourceUid($result['source_uid']);
        $this->validateSourceData($result['source_data']);
        $this->validateData($result['data']);

        return $result;
    }

    /**
     * @param string $source
     * @return string
     * @throws ValidateException
     */
    protected function validateSource($source)
    {
        if (empty($source)) {
            throw new ValidateException('Source can\'t be empty');
        }

        return $source;
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
     * @param string $source_uid
     * @return string
     * @throws ValidateException
     */
    protected function validateSourceUid($source_uid)
    {
        if (empty($source_uid)) {
            throw new ValidateException('Source Uid can\'t be empty');
        }

        return $source_uid;
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
     * @param array $source_data
     * @return array
     * @throws ValidateException
     */
    protected function validateSourceData($source_data)
    {
        if (empty($source_data)) {
            throw new ValidateException('Source Data can\'t be empty');
        }

        return $source_data;
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

    /**
     * @param array $data
     * @return array
     * @throws ValidateException
     */
    protected function validateData($data)
    {
        if (empty($data)) {
            throw new ValidateException('Data can\'t be empty');
        }

        if (empty($data[Elements\Lead::TYPE_MANY][0]['name'])) {
            throw new ValidateException('Can\'t create unsorted without at least one lead');
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array_filter($this->_data);
    }

    /**
     * @return string
     */
    protected function getSourceToAmo()
    {
        return $this->getSource();
    }

    /**
     * @return string
     */
    protected function getSourceUidToAmo()
    {
        return $this->getSourceUid();
    }

    /**
     * @return array
     */
    protected function getSourceDataToAmo()
    {
        return $this->getSourceData();
    }

    /**
     * @return array
     */
    protected function getDataToAmo()
    {
        return $this->getData();
    }
}
