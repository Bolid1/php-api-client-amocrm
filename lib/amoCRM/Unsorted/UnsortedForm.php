<?php

namespace amoCRM\Unsorted;

use amoCRM\Exceptions\ValidateException;

/**
 * Class UnsortedForm
 * @package amoCRM\Unsorted
 * @TODO: Более удобное управление данными
 */
final class UnsortedForm extends BaseUnsorted
{
    const FORM_TYPE_ID_DEFAULT = 1;
    const FORM_TYPE_ID_WORDPRESS = 2;

    /**
     * @throws ValidateException
     */
    protected function validateSourceData()
    {
        parent::validateSourceData();

        $this->ensureDataNotEmpty($this->getSourceData('data'));
        $this->ensureFormType($this->getSourceData('form_type'));
        $this->ensureOriginNotEmptyArray($this->getSourceData('origin'));

        if ($this->getSourceData('form_type') === self::FORM_TYPE_ID_WORDPRESS) {
            $this->ensureWordPressOrigin($this->getSourceData('origin'));
        }

        $this->ensureFormRequiredFields($this->getSourceData());
    }

    /**
     * @param array $data
     * @throws ValidateException
     */
    private function ensureDataNotEmpty($data)
    {
        if (empty($data)) {
            throw new ValidateException('Source data elements data empty');
        }
    }

    /**
     * @param integer $form_type
     * @throws ValidateException
     */
    private function ensureFormType($form_type)
    {
        if (empty($form_type)) {
            throw new ValidateException('Form type is empty');
        }

        $allowed_forms_types = [self::FORM_TYPE_ID_DEFAULT, self::FORM_TYPE_ID_WORDPRESS];
        if (!in_array($form_type, $allowed_forms_types, true)) {
            throw new ValidateException(sprintf('Not allowed form type "%s"', $form_type));
        }
    }

    /**
     * @param array $origin
     * @throws ValidateException
     */
    private function ensureOriginNotEmptyArray($origin)
    {
        if (empty($origin) || !is_array($origin)) {
            throw new ValidateException('Invalid origin data');
        }
    }

    /**
     * @param array $origin
     */
    private function ensureWordPressOrigin($origin)
    {
        foreach (['url', 'request_id', 'form_type'] as $key) {
            $this->ensureArrayHasStringField($origin, $key);
        }
    }

    /**
     * @param array $array
     * @param string $field
     * @throws ValidateException
     */
    private function ensureArrayHasStringField(array $array, $field)
    {
        if (empty($array[$field])) {
            throw new ValidateException('Empty ' . $field);
        }

        if (!is_string($array[$field]) && !is_numeric($array[$field])) {
            throw new ValidateException('Invalid ' . $field . ' type');
        }
    }

    /**
     * @param array $source_data
     */
    protected function ensureFormRequiredFields(array $source_data)
    {
        foreach (['form_id', 'date', 'from'] as $key) {
            $this->ensureArrayHasStringField($source_data, $key);
        }
    }
}
