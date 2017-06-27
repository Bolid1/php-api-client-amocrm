<?php

namespace amoCRM\Entities\Elements;

use amoCRM\Exceptions;

/**
 * Class BaseElement
 * @package amoCRM\Entities\Elements
 * Класс для хранения информации об элементе сущности amoCRM
 */
abstract class BaseElement
{
    /** @var integer */
    private $_id;

    /** @var string */
    private $_name;

    /** @var integer */
    private $_date_create;
    /** @var integer - id создателя */
    private $_created_by;

    /** @var integer */
    private $_date_modify;

    /**
     * id пользователя,
     * который последним менял элемент
     * @var integer
     */
    private $_modified_by;

    /**
     * id пользователя,
     * ответственного за элемент
     * @var integer
     */
    private $_responsible;

    /** @var array.<CustomField> */
    private $_custom_fields = [];

    /**
     * Массив тегов. Не ициализируем,
     * так как если при изменении передать
     * пустую строку, то все тэги очистятся
     *
     * @var array
     */
    private $_tags;

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->_id = $this->parseInteger($id);
    }

    /**
     * @param integer $number
     * @param bool $can_be_less_one
     * @return int
     * @throws Exceptions\InvalidArgumentException
     */
    protected function parseInteger($number, $can_be_less_one = false)
    {
        if (!is_numeric($number)) {
            throw new Exceptions\InvalidArgumentException(sprintf('Invalid integer "%s"', $number));
        }

        $number = (int)$number;

        if ($can_be_less_one !== true && $number < 1) {
            throw new Exceptions\InvalidArgumentException(sprintf('Invalid integer "%s"', $number));
        }

        return $number;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = (string)$name;
    }

    /**
     * @param string|integer $date_create
     */
    public function setDateCreate($date_create)
    {
        $this->_date_create = $this->parseDate($date_create);
    }

    /**
     * @param integer|string $date
     * @return int
     * @throws Exceptions\InvalidArgumentException
     */
    private function parseDate($date)
    {
        if (is_numeric($date)) {
            return (int)$date;
        }

        $result = is_string($date) ? strtotime($date) ?: null : null;

        if (is_null($result)) {
            throw new Exceptions\InvalidArgumentException(sprintf('Invalid date "%s"', $date));
        }

        return $result;
    }

    /**
     * @param integer $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->_created_by = $this->parseInteger($created_by);
    }

    /**
     * @param string|integer $date_modify
     */
    public function setDateModify($date_modify)
    {
        $this->_date_modify = $this->parseDate($date_modify);
    }

    /**
     * @param integer $modified_by
     */
    public function setModifiedBy($modified_by)
    {
        $this->_modified_by = $this->parseInteger($modified_by);
    }

    /**
     * @param integer $responsible
     */
    public function setResponsible($responsible)
    {
        $this->_responsible = $this->parseInteger($responsible);
    }

    /**
     * @param CustomFields\BaseCustomField $custom_fields
     */
    public function addCustomField(CustomFields\BaseCustomField $custom_fields)
    {
        $this->_custom_fields[] = $custom_fields;
    }

    /**
     * @param string $tag
     */
    public function addTag($tag)
    {
        if (!isset($this->_tags)) {
            $this->_tags = [];
        }

        $tag = (string)$tag;

        if (mb_strlen($tag) > 0) {
            $this->_tags[$tag] = true;
        }
    }

    /**
     * @param string $tag
     */
    public function removeTag($tag)
    {
        if (!isset($this->_tags)) {
            return;
        }

        $tag = (string)$tag;
        unset($this->_tags[$tag]);
    }

    /**
     * @param array $tags
     */
    public function addTags(array $tags)
    {
        array_map([$this, 'addTag'], $tags);
    }

    /**
     * Prepare instance for sending to amoCRM
     *
     * @return array
     */
    public function toAmo()
    {
        $element = [];

        if (isset($this->_id)) {
            $element['id'] = $this->_id;
        }

        if (isset($this->_name)) {
            $element['name'] = $this->_name;
        }

        if (isset($this->_date_create)) {
            $element['date_create'] = $this->_date_create;
        }

        if (isset($this->_created_by)) {
            $element['created_user_id'] = $this->_created_by;
        }

        if (isset($this->_date_modify)) {
            $element['last_modified'] = $this->_date_modify;
        }

        if (isset($this->_modified_by)) {
            $element['modified_user_id'] = $this->_modified_by;
        }

        if (isset($this->_responsible)) {
            $element['responsible_user_id'] = $this->_responsible;
        }

        /** @var CustomFields\BaseCustomField $custom_field */
        foreach ($this->_custom_fields as $custom_field) {
            if (!isset($element['custom_fields'])) {
                $element['custom_fields'] = [];
            }

            $element['custom_fields'][] = $custom_field->toAmo();
        }

        if (isset($this->_tags)) {
            $element['tags'] = implode(',', array_keys($this->_tags));
        }

        return $element;
    }
}
