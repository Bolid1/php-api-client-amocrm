<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity;
use amoCRM\Entity\UnsortedForm;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\UnsortedForm
 */
final class UnsortedFormTest extends TestCase
{
    private static $example = [
        'source' => 'http://example.info',
        'source_uid' => '1498585325fd4e2ca0e372af6593cd69a991d37585806383581',
        'source_data' => [
            'data' => [
                'name_'.Entity\Contact::TYPE_NUMERIC => [
                    'type' => 'text',
                    'id' => 'name',
                    'element_type' => Entity\Contact::TYPE_NUMERIC,
                    'name' => 'ФИО',
                    'value' => '0c0gaCbr0',
                ],
                'name_'.Entity\Lead::TYPE_NUMERIC => [
                    'type' => 'text',
                    'id' => 'name',
                    'element_type' => Entity\Lead::TYPE_NUMERIC,
                    'name' => 'ФИО',
                    'value' => 'Lead name',
                ],
                '61237_'.Entity\Contact::TYPE_NUMERIC => [
                    'type' => 'multitext',
                    'id' => '61237',
                    'element_type' => Entity\Contact::TYPE_NUMERIC,
                    'name' => 'Телефон',
                    'value' => ['+7 999 999 99-99'],
                ],
                '61238_'.Entity\Lead::TYPE_NUMERIC => [
                    'type' => 'numeric',
                    'id' => '61238',
                    'element_type' => Entity\Lead::TYPE_NUMERIC,
                    'name' => 'Number',
                    'value' => 123,
                ],
                '61239_'.Entity\Contact::TYPE_NUMERIC => [
                    'type' => 'text',
                    'id' => '61239',
                    'element_type' => Entity\Contact::TYPE_NUMERIC,
                    'name' => 'Email',
                    'value' => 'some@example.com',
                ],
            ],
            'form_id' => 180724,
            'form_type' => UnsortedForm::FORM_TYPE_ID_WORDPRESS,
            'origin' => [
                'url' => 'https://D33.wu8s.com',
                'request_id' => '1498585325fd4e2ca0e372af6593cd69a991d37585806383581',
                'form_type' => UnsortedForm::FORM_TYPE_ID_WORDPRESS,
            ],
            'date' => 1498585317,
            'form_name' => 'My form',
            'from' => 'http://example.info',
        ],
        'data' => [
            Entity\Lead::TYPE_MANY => [
                [
                    'name' => 'Lead name',
                    'custom_fields' => [
                        [
                            'id' => '61238',
                            'values' => [
                                [
                                    'value' => 123,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            Entity\Contact::TYPE_MANY => [
                [
                    'name' => '0c0gaCbr0',
                    'custom_fields' => [
                        [
                            'id' => '61237',
                            'values' => [
                                [
                                    'value' => '+7 999 999 99-99',
                                    'enum' => 'WORK',
                                ],
                            ],
                        ],
                        [
                            'id' => '61239',
                            'values' => [
                                [
                                    'value' => 'some@example.com',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    public function testValidateSourceData()
    {
        $unsorted = $this->buildWithoutSourceData(['skip_lead' => true, 'skip_contact' => true]);
        $source_data = self::$example['source_data'];
        $source_data['data'] = [];
        $this->setSourceData($unsorted, $source_data, self::$example['source_data']['data']);

        $this->assertEquals(self::$example, $unsorted->toAmo());
    }

    /**
     * @param array $options
     * @return UnsortedForm
     */
    public function buildWithoutSourceData(array $options = [])
    {
        $unsorted = new UnsortedForm;
        if (empty($options['skip_lead'])) {
            $unsorted->addLead(reset(self::$example['data'][Entity\Lead::TYPE_MANY]));
        }
        if (empty($options['skip_contact'])) {
            $unsorted->addContact(reset(self::$example['data'][Entity\Contact::TYPE_MANY]));
        }
        $unsorted->setSource(self::$example['source']);
        $unsorted->setSourceUid(self::$example['source_uid']);

        return $unsorted;
    }

    /**
     * @param UnsortedForm $unsorted
     * @param array $source_data
     * @param array $fields
     */
    private function setSourceData(UnsortedForm $unsorted, array $source_data, $fields = null)
    {
        $unsorted->setSourceData($source_data);

        if ($fields === null && isset($source_data['data'])) {
            $fields = $source_data['data'];
        }

        if (empty($fields)) {
            return;
        }

        $unsorted->parseFieldsValues($fields);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Source data elements data empty
     */
    public function testEnsureDataNotEmptyThrowValidateException()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['data']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @return array
     */
    private function buildWithSourceData()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = self::$example['source_data'];

        return array($unsorted, $source_data);
    }

    /**
     * @param UnsortedForm $unsorted
     * @param array $source_data
     */
    private function setSourceDataAndCallToAmo($unsorted, $source_data)
    {
        $this->setSourceData($unsorted, $source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Form type is empty
     */
    public function testEnsureFormTypeThrowValidateException()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['form_type']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Not allowed form type "12"
     */
    public function testEnsureFormTypeThrowValidateExceptionOnInvalid()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        $source_data['form_type'] = 12;
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Not allowed form type "2"
     */
    public function testEnsureFormTypeThrowValidateExceptionOnString()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        $source_data['form_type'] = (string)UnsortedForm::FORM_TYPE_ID_WORDPRESS;
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage l
     */
    public function testEnsureOriginNotEmptyArrayThrowValidateException()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['origin']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage l
     */
    public function testEnsureWordPressOriginUrlThrowValidateException()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['origin']['url']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Empty request_id
     */
    public function testEnsureWordPressOriginRequestIdThrowValidateException()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['origin']['request_id']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Empty form_type
     */
    public function testEnsureWordPressOriginFormTypeThrowValidateException()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['origin']['form_type']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Empty form_id
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFormId()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['form_id']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Invalid form_id type
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFormIdType()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        $source_data['form_id'] = ['some array'];
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Empty date
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldDate()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['date']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Invalid date type
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldDateType()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        $source_data['date'] = ['some array'];
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Empty from
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFrom()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        unset($source_data['from']);
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     * @expectedExceptionMessage Invalid from type
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFromType()
    {
        list($unsorted, $source_data) = $this->buildWithSourceData();
        $source_data['from'] = ['some array'];
        $this->setSourceDataAndCallToAmo($unsorted, $source_data);
    }
}
