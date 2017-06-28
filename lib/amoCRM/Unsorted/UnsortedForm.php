<?php

namespace amoCRM\Unsorted;

use amoCRM\Entities\Elements\Lead;
use amoCRM\Entities\Elements\Contact;
use amoCRM\Exceptions\ValidateException;
use amoCRM\Entities\Elements\CustomFields;
use amoCRM\Unsorted\UnsortedFormFields\BaseFormField;
use amoCRM\Unsorted\UnsortedFormFields\FormFieldFactory;

/**
 * Class UnsortedForm
 * @package amoCRM\Unsorted
 */
final class UnsortedForm extends BaseUnsorted
{
    const CATEGORY = 'forms';

    const FORM_TYPE_ID_DEFAULT = 1;
    const FORM_TYPE_ID_WORDPRESS = 2;

    /**
     * @param array $source_data
     * @return array
     */
    protected function validateSourceData($source_data)
    {
        $source_data = parent::validateSourceData($source_data);

        $this->ensureFieldsNotEmpty($source_data['data']);
        $this->ensureFormType($source_data['form_type']);
        $this->ensureOriginNotEmptyArray($source_data['origin']);

        if ($this->getSourceData('form_type') === self::FORM_TYPE_ID_WORDPRESS) {
            $this->ensureWordPressOrigin($source_data['origin']);
        }

        $this->ensureFormRequiredFields($source_data);

        return $source_data;
    }

    /**
     * @param array $data
     * @throws ValidateException
     */
    private function ensureFieldsNotEmpty($data)
    {
        if (empty($data)) {
            throw new ValidateException('Source data elements data empty');
        }
    }

    /**
     * @param BaseFormField $field
     */
    public function addFieldValue(BaseFormField $field)
    {
        $data = $this->getSourceData('data') ?: [];
        $data[implode('_', [$field->getId(), $field->getElementType()])] = $field;

        $source_data = $this->getSourceData();
        $source_data['data'] = $data;

        $this->setSourceData($source_data);
    }

    public function setSourceData(array $source_data)
    {
        $fields_as_array = [];

        if (isset($source_data['data'])) {
            foreach ($source_data['data'] as $field) {
                if (is_array($field)) {
                    $fields_as_array[] = $field;
                }
            }
        }

        parent::setSourceData($source_data);


        if (!empty($fields_as_array)) {
            $this->parseFieldsValues($fields_as_array);
        }
    }

    /**
     * Convert fields array to array of BaseFormField
     * @param array $fields
     */
    public function parseFieldsValues(array $fields)
    {
        foreach ($fields as $field_params) {
            $field = FormFieldFactory::make($field_params['type'], $field_params['id'], $field_params['element_type']);
            $field->setName($field_params['name']);
            $field->setValue($field_params['value']);

            $this->addFieldValue($field);
        }
    }

    /**
     * @return array
     */
    protected function getSourceDataToAmo()
    {
        $source_data = [
            'data' => $this->getSourceDataFieldsToAmo(),
            'form_id' => $this->getSourceData('form_id'),
            'form_type' => $this->getSourceData('form_type'),
            'origin' => $this->getSourceData('origin'),
            'date' => $this->getSourceData('date'),
            'form_name' => $this->getSourceData('form_name'),
            'from' => $this->getSourceData('from'),
        ];

        return $source_data;
    }

    /**
     * Convert fields to elements
     * @return array
     */
    protected function getDataToAmo()
    {
        $elements = parent::getDataToAmo();
        $fields = $this->getSourceDataFieldsToAmo();
        if (empty($fields)) {
            return $elements;
        }

        $lead = new Lead;
        $contact = new Contact;

        foreach ($fields as $field) {
            switch ($field['element_type']) {
                case Contact::TYPE_NUMERIC:
                    $obj = &$contact;
                    break;
                case Lead::TYPE_NUMERIC:
                default:
                    $obj = &$lead;
                    break;
            }

            if ($field['id'] === 'name') {
                $obj->setName($field['value']);
                unset($obj);
                continue;
            }

            unset($cf);
            switch ($field['type']) {
                case UnsortedFormFields\FormFieldText::TYPE:
                    $cf = new CustomFields\CustomFieldText($field['id']);
                    $cf->setValue($field['value']);
                    break;
                case UnsortedFormFields\FormFieldNumber::TYPE:
                    $cf = new CustomFields\CustomFieldNumber($field['id']);
                    $cf->setValue($field['value']);
                    break;
                case UnsortedFormFields\FormFieldMultiText::TYPE:
                    $cf = new CustomFields\CustomFieldPhones($field['id']);
                    foreach ((array)$field['value'] as $value) {
                        $cf->addValue($cf->getDefaultEnum(), $value);
                    }
                    break;
            }

            if (isset($cf)) {
                $obj->addCustomField($cf);
            }

            unset($obj);
        }

        $lead = $lead->toAmo();
        $contact = $contact->toAmo();
        if (!empty($lead)) {
            $elements[Lead::TYPE_MANY][] = $lead;
        }

        if (!empty($contact)) {
            $elements[Contact::TYPE_MANY][] = $contact;
        }

        return $elements;
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

    /**
     * @return array
     */
    private function getSourceDataFieldsToAmo()
    {
        $result = [];
        $fields = $this->getSourceData('data') ?: [];

        foreach ($fields as $key => $field) {
            if ($field instanceof BaseFormField) {
                $result[$key] = $field->toAmo();
            }
        }

        return $result;
    }
}
