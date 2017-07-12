<?php

namespace Tests\amoCRM\Unsorted;

use amoCRM\Entity;
use amoCRM\Unsorted\BaseUnsorted;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseUnsortedTest
 * @package amoCRM\Unsorted
 * @covers \amoCRM\Unsorted\BaseUnsorted
 */
final class BaseUnsortedTest extends TestCase
{
    private static $example = [
        'source' => 'some_source',
        'source_uid' => 'test',
        'source_data' => [
            'foo' => 'bar',
        ],
        'data' => [
            Entity\Lead::TYPE_MANY => [['name' => 'some name']],
            Entity\Contact::TYPE_MANY => [['name' => 'some name']],
            'companies' => [['name' => 'some name']],
        ],
    ];

    public function testSetSource()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource(self::$example['source']);
        $this->assertEquals(self::$example['source'], $unsorted->getSource());
    }

    /**
     * @return BaseUnsorted
     */
    private function buildMock()
    {
        $stub = $this->getMockBuilder(BaseUnsorted::class)
            ->enableOriginalConstructor()
            ->setMethods()
            ->getMock();

        /** @var BaseUnsorted $stub */
        return $stub;
    }

    public function testSetSourceUid()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceUid(self::$example['source_uid']);
        $this->assertEquals(self::$example['source_uid'], $unsorted->getSourceUid());
    }

    public function testSetSourceData()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceData(self::$example['source_data']);
        $this->assertEquals(self::$example['source_data'], $unsorted->getSourceData());
    }

    public function testSetSourceDataByKey()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceData(self::$example['source_data']);
        $this->assertEquals(self::$example['source_data']['foo'], $unsorted->getSourceData('foo'));
    }

    public function testToAmo()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource(self::$example['source']);
        $unsorted->setSourceUid(self::$example['source_uid']);
        $unsorted->setSourceData(self::$example['source_data']);
        $unsorted->addLead(reset(self::$example['data'][Entity\Lead::TYPE_MANY]));
        $unsorted->addContact(reset(self::$example['data'][Entity\Contact::TYPE_MANY]));
        $unsorted->addCompany(reset(self::$example['data']['companies']));

        $this->assertEquals(self::$example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Data can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptyData()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource(self::$example['source']);
        $unsorted->setSourceUid(self::$example['source_uid']);
        $unsorted->setSourceData(self::$example['source_data']);

        $this->assertEquals(self::$example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Can't create unsorted without at least one lead
     */
    public function testToAmoThrowValidateExceptionEmptyLeadName()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource(self::$example['source']);
        $unsorted->setSourceUid(self::$example['source_uid']);
        $unsorted->setSourceData(self::$example['source_data']);
        $unsorted->addLead(['date_create' => time()]);

        $this->assertEquals(self::$example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Source can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptySource()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSourceUid(self::$example['source_uid']);
        $unsorted->setSourceData(self::$example['source_data']);
        $unsorted->addLead(reset(self::$example['data'][Entity\Lead::TYPE_MANY]));

        $this->assertEquals(self::$example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Source Uid can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptySourceUid()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource(self::$example['source']);
        $unsorted->setSourceData(self::$example['source_data']);
        $unsorted->addLead(reset(self::$example['data'][Entity\Lead::TYPE_MANY]));

        $this->assertEquals(self::$example, $unsorted->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\ValidateException
     * @expectedExceptionMessage Source Data can't be empty
     */
    public function testToAmoThrowValidateExceptionEmptySourceData()
    {
        $unsorted = $this->buildMock();
        $unsorted->setSource(self::$example['source']);
        $unsorted->setSourceUid(self::$example['source_uid']);
        $unsorted->addLead(reset(self::$example['data'][Entity\Lead::TYPE_MANY]));

        $this->assertEquals(self::$example, $unsorted->toAmo());
    }

    public function testAddLead()
    {
        $element = reset(self::$example['data'][Entity\Lead::TYPE_MANY]);
        $unsorted = $this->buildMock();
        $unsorted->addLead($element);

        $this->assertEquals([Entity\Lead::TYPE_MANY => [$element]], $unsorted->getData());
    }

    public function testAddContact()
    {
        $element = reset(self::$example['data'][Entity\Contact::TYPE_MANY]);
        $unsorted = $this->buildMock();
        $unsorted->addContact($element);

        $this->assertEquals([Entity\Contact::TYPE_MANY => [$element]], $unsorted->getData());
    }

    public function testAddCompany()
    {
        $element = reset(self::$example['data']['companies']);
        $unsorted = $this->buildMock();
        $unsorted->addCompany($element);

        $this->assertEquals(['companies' => [$element]], $unsorted->getData());
    }
}
