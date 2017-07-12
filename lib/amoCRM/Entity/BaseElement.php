<?php

namespace amoCRM\Entity;

use amoCRM\Exceptions;

/**
 * Class BaseElement
 * @package amoCRM\Entity
 * Класс для хранения информации об элементе сущности amoCRM
 */
abstract class BaseElement
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var integer */
    private $date_create;
    /** @var integer - id создателя */
    private $created_by;

    /** @var integer */
    private $date_modify;

    /**
     * id пользователя,
     * который последним менял элемент
     * @var integer
     */
    private $modified_by;

    /**
     * id пользователя,
     * ответственного за элемент
     * @var integer
     */
    private $responsible;

    /** @var array.<CustomField> */
    private $custom_fields = [];

    /**
     * Массив тегов. Не ициализируем,
     * так как если при изменении передать
     * пустую строку, то все тэги очистятся
     *
     * @var array
     */
    private $tags;

    /**
     * @param integer $id
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setId($id)
    {
        $this->id = $this->parseInteger($id);
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
        $this->name = (string)$name;
    }

    /**
     * @param string|integer $date_create
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = $this->parseDate($date_create);
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

        $result = null;

        if (is_string($date)) {
            $result = strtotime($date) ?: null;
        }

        if ($result === null) {
            throw new Exceptions\InvalidArgumentException(sprintf('Invalid date "%s"', $date));
        }

        return $result;
    }

    /**
     * @param integer $created_by
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $this->parseInteger($created_by);
    }

    /**
     * @param string|integer $date_modify
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setDateModify($date_modify)
    {
        $this->date_modify = $this->parseDate($date_modify);
    }

    /**
     * @param integer $modified_by
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $this->parseInteger($modified_by);
    }

    /**
     * @param integer $responsible
     * @throws \amoCRM\Exceptions\InvalidArgumentException
     */
    public function setResponsible($responsible)
    {
        $this->responsible = $this->parseInteger($responsible);
    }

    /**
     * @param BaseCustomField $custom_fields
     */
    public function addCustomField(BaseCustomField $custom_fields)
    {
        $this->custom_fields[] = $custom_fields;
    }

    /**
     * @param string $tag
     */
    public function addTag($tag)
    {
        if ($this->tags === null) {
            $this->tags = [];
        }

        $tag = (string)$tag;

        if (mb_strlen($tag) > 0) {
            $this->tags[$tag] = true;
        }
    }

    /**
     * @param string $tag
     */
    public function removeTag($tag)
    {
        if ($this->tags === null) {
            return;
        }

        $tag = (string)$tag;
        unset($this->tags[$tag]);
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

        if ($this->id !== null) {
            $element['id'] = $this->id;
        }

        if ($this->name !== null) {
            $element['name'] = $this->name;
        }

        if ($this->date_create !== null) {
            $element['date_create'] = $this->date_create;
        }

        if ($this->created_by !== null) {
            $element['created_user_id'] = $this->created_by;
        }

        if ($this->date_modify !== null) {
            $element['last_modified'] = $this->date_modify;
        }

        if ($this->modified_by !== null) {
            $element['modified_user_id'] = $this->modified_by;
        }

        if ($this->responsible !== null) {
            $element['responsible_user_id'] = $this->responsible;
        }

        /** @var BaseCustomField $custom_field */
        foreach ($this->custom_fields as $custom_field) {
            if (!isset($element['custom_fields'])) {
                $element['custom_fields'] = [];
            }

            $element['custom_fields'][] = $custom_field->toAmo();
        }

        if ($this->tags !== null) {
            $element['tags'] = implode(',', array_keys($this->tags));
        }

        return $element;
    }
}
