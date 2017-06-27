<?php

namespace Tests\amoCRM\Unsorted;

use amoCRM\Unsorted\BaseUnsorted;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseUnsortedTest
 * @package amoCRM\Unsorted
 * @covers \amoCRM\Unsorted\BaseUnsorted
 */
final class BaseUnsortedTest extends TestCase
{
    /** @var array */
    private $_example = [
        'source' => 'some_source',
        'source_uid' => 'test',
        'source_data' => [
            'foo' => 'bar',
        ],
        'data' => [
            'leads' => [['name' => 'some name']],
            'contacts' => [['name' => 'some name']],
            'companies' => [['name' => 'some name']],
        ],
    ];

    public function testSetSource()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource($this->_example['source']);
        $this->assertEquals($this->_example['source'], $unsorted->getSource());
    }

    /**
     * @return BaseUnsorted
     */
    private function buildMock()
    {
        $stub = $this->getMockBuilder(BaseUnsorted::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        /** @var BaseUnsorted $stub */
        return $stub;
    }

    public function testSetSourceUid()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceUid($this->_example['source_uid']);
        $this->assertEquals($this->_example['source_uid'], $unsorted->getSourceUid());
    }

    public function testSetSourceData()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceData($this->_example['source_data']);
        $this->assertEquals($this->_example['source_data'], $unsorted->getSourceData());
    }

    public function testSetSourceDataByKey()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceData($this->_example['source_data']);
        $this->assertEquals($this->_example['source_data']['foo'], $unsorted->getSourceData('foo'));
    }

    public function testToAmo()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource($this->_example['source']);
        $unsorted->setSourceUid($this->_example['source_uid']);
        $unsorted->setSourceData($this->_example['source_data']);
        $unsorted->addLead(reset($this->_example['data']['leads']));
        $unsorted->addContact(reset($this->_example['data']['contacts']));
        $unsorted->addCompany(reset($this->_example['data']['companies']));

        $this->assertEquals($this->_example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Data can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptyData()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource($this->_example['source']);
        $unsorted->setSourceUid($this->_example['source_uid']);
        $unsorted->setSourceData($this->_example['source_data']);

        $this->assertEquals($this->_example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Can't create unsorted without at least one lead
     */
    public function testToAmoThrowValidateExceptionEmptyLeadName()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource($this->_example['source']);
        $unsorted->setSourceUid($this->_example['source_uid']);
        $unsorted->setSourceData($this->_example['source_data']);
        $unsorted->addLead(['date_create' => time()]);

        $this->assertEquals($this->_example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Source can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptySource()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceUid($this->_example['source_uid']);
        $unsorted->setSourceData($this->_example['source_data']);
        $unsorted->addLead(reset($this->_example['data']['leads']));

        $this->assertEquals($this->_example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Source Uid can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptySourceUid()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource($this->_example['source']);
        $unsorted->setSourceData($this->_example['source_data']);
        $unsorted->addLead(reset($this->_example['data']['leads']));

        $this->assertEquals($this->_example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Source Data can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptySourceData()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource($this->_example['source']);
        $unsorted->setSourceUid($this->_example['source_uid']);
        $unsorted->addLead(reset($this->_example['data']['leads']));

        $this->assertEquals($this->_example, $unsorted->toAmo());
    }

    public function testAddLead()
    {
        $element = reset($this->_example['data']['leads']);
        $unsorted = $this->buildMock();
        $unsorted->addLead($element);

        $this->assertEquals(['leads' => [$element]], $unsorted->getData());
    }

    public function testAddContact()
    {
        $element = reset($this->_example['data']['contacts']);
        $unsorted = $this->buildMock();
        $unsorted->addContact($element);

        $this->assertEquals(['contacts' => [$element]], $unsorted->getData());
    }

    public function testAddCompany()
    {
        $element = reset($this->_example['data']['companies']);
        $unsorted = $this->buildMock();
        $unsorted->addCompany($element);

        $this->assertEquals(['companies' => [$element]], $unsorted->getData());
    }
}
