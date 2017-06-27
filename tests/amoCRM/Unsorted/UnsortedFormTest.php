<?php

namespace Tests\amoCRM\Unsorted;

use amoCRM\Unsorted\UnsortedForm;
use PHPUnit\Framework\TestCase;

/**
 * Class UnsortedFormTest
 * @package Tests\amoCRM\Unsorted
 * @covers \amoCRM\Unsorted\UnsortedForm
 */
final class UnsortedFormTest extends TestCase
{
    private $_example = [
        'source' => 'http://OulVKvE5.info',
        'source_uid' => '1498585325fd4e2ca0e372af6593cd69a991d37585806383581',
        'source_data' => [
            'data' => [
                'name_1' => [
                    'type' => 'text',
                    'id' => 'name',
                    'element_type' => '1',
                    'name' => 'ФИО',
                    'value' => '0c0gaCbr0',
                ],
                '61237_1' => [
                    'type' => 'multitext',
                    'id' => '61237',
                    'element_type' => '1',
                    'name' => 'Телефон',
                    'value' => ['odhgPM'],
                ],
                '61239_1' => [
                    'type' => 'multitext',
                    'id' => '61239',
                    'element_type' => '1',
                    'name' => 'Email',
                    'value' => ['jGHVE9@7nTX.YmgGIlVzi.xWK.org',],
                ],
                'note_2' => [
                    'type' => 'text',
                    'id' => 'note',
                    'element_type' => '2',
                    'name' => 'Примечание',
                    'value' => 'fTYLaUlMj9TiA',
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
            'form_name' => 'kRq0ZD2DZHV',
            'from' => 'http://OulVKvE5.info',
        ],
        'data' => [
            'leads' => [
                [
                    'name' => 'Lead from tests form unsorted #1498585325',
                    'notes' => [['text' => 'fTYLaUlMj9TiA', 'note_type' => 4]],
                ],
            ],
            'contacts' => [
                [
                    'name' => '0c0gaCbr0',
                    'custom_fields' => [
                        [
                            'id' => '61237',
                            'values' => [
                                [
                                    'value' => 'odhgPM',
                                    'enum' => 136785,
                                ],
                            ],
                        ],
                        [
                            'id' => '61239',
                            'values' => [
                                [
                                    'value' => 'jGHVE9@7nTX.YmgGIlVzi.xWK.org',
                                    'enum' => 136797,
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
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        $unsorted->setSourceData($source_data);
        $this->assertEquals($this->_example, $unsorted->toAmo());
    }

    /**
     * @return UnsortedForm
     */
    public function buildWithoutSourceData()
    {
        $unsorted = new UnsortedForm;
        $unsorted->addLead(reset($this->_example['data']['leads']));
        $unsorted->addContact(reset($this->_example['data']['contacts']));
        $unsorted->setSource($this->_example['source']);
        $unsorted->setSourceUid($this->_example['source_uid']);

        return $unsorted;
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Source data elements data empty
     */
    public function testEnsureDataNotEmptyThrowValidateException()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['data']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Form type is empty
     */
    public function testEnsureFormTypeThrowValidateException()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['form_type']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Not allowed form type "12"
     */
    public function testEnsureFormTypeThrowValidateExceptionOnInvalid()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        $source_data['form_type'] = 12;
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Not allowed form type "2"
     */
    public function testEnsureFormTypeThrowValidateExceptionOnString()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        $source_data['form_type'] = (string)UnsortedForm::FORM_TYPE_ID_WORDPRESS;
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage l
     */
    public function testEnsureOriginNotEmptyArrayThrowValidateException()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['origin']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage l
     */
    public function testEnsureWordPressOriginUrlThrowValidateException()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['origin']['url']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Empty request_id
     */
    public function testEnsureWordPressOriginRequestIdThrowValidateException()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['origin']['request_id']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Empty form_type
     */
    public function testEnsureWordPressOriginFormTypeThrowValidateException()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['origin']['form_type']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Empty form_id
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFormId()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['form_id']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Invalid form_id type
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFormIdType()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        $source_data['form_id'] = ['some array'];
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Empty date
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldDate()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['date']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Invalid date type
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldDateType()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        $source_data['date'] = ['some array'];
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Empty from
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFrom()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        unset($source_data['from']);
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Invalid from type
     */
    public function testEnsureFormRequiredThrowValidateExceptionFieldFromType()
    {
        $unsorted = $this->buildWithoutSourceData();
        $source_data = $this->_example['source_data'];
        $source_data['from'] = ['some array'];
        $unsorted->setSourceData($source_data);
        $unsorted->toAmo();
    }
}
