<?php

namespace amoCRM\Entity;

use amoCRM\Entity;
use amoCRM\Exception\RuntimeException;
use amoCRM\Exception\ValidateException;

/**
 * Class BaseUnsorted
 * @package amoCRM\Entity
 */
abstract class BaseUnsorted
{
    /** @var string */
    private $source;
    /** @var string */
    private $source_uid;
    /** @var array */
    private $source_data;
    /** @var array */
    private $data;

    public function __construct()
    {
        $this->data = [
            Entity\Lead::TYPE_MANY => [],
            Entity\Contact::TYPE_MANY => [],
            Entity\Company::TYPE_MANY => [],
        ];
    }

    /**
     * @param array $lead
     */
    public function addLead(array $lead)
    {
        $this->data[Entity\Lead::TYPE_MANY][] = $lead;
    }

    /**
     * @param array $contact
     */
    public function addContact(array $contact)
    {
        $this->data[Entity\Contact::TYPE_MANY][] = $contact;
    }

    /**
     * @param array $company
     */
    public function addCompany(array $company)
    {
        $this->data[Entity\Company::TYPE_MANY][] = $company;
    }

    /**
     * Prepare current unsorted element for send to amoCRM
     * @return array
     * @throws \amoCRM\Exception\ValidateException
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
     * @return string
     */
    protected function getSourceToAmo()
    {
        return $this->getSource();
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    protected function getSourceUidToAmo()
    {
        return $this->getSourceUid();
    }

    /**
     * @return string
     */
    public function getSourceUid()
    {
        return $this->source_uid;
    }

    /**
     * @param string $source_uid
     */
    public function setSourceUid($source_uid)
    {
        $this->source_uid = $source_uid;
    }

    /**
     * @return array
     */
    protected function getSourceDataToAmo()
    {
        return $this->getSourceData();
    }

    /**
     * @param string [$key=null]
     *
     * @return array|mixed|null
     */
    public function getSourceData($key = null)
    {
        $result = $this->source_data;
        if ($key !== null) {
            $result = isset($result[$key]) ? $result[$key] : null;
        }

        return $result;
    }

    /**
     * @param array $source_data
     */
    public function setSourceData(array $source_data)
    {
        $this->source_data = $source_data;
    }

    /**
     * @return array
     */
    protected function getDataToAmo()
    {
        return $this->getData();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array_filter($this->data);
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
     * @param array $data
     * @return array
     * @throws ValidateException
     */
    protected function validateData($data)
    {
        if (empty($data)) {
            throw new ValidateException('Data can\'t be empty');
        }

        if (empty($data[Entity\Lead::TYPE_MANY][0]['name'])) {
            throw new ValidateException('Can\'t create unsorted without at least one lead');
        }

        return $data;
    }
}
