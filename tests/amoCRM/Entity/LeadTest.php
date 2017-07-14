<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseElement;
use amoCRM\Entity\Lead;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\Lead
 */
final class LeadTest extends TestCase
{
    public function testInstanceOfBaseElement()
    {
        $this->assertInstanceOf(
            BaseElement::class,
            new Lead
        );
    }

    public function testSetPrice()
    {
        $element = new Lead;

        $number = 10000;
        $element->setPrice($number);

        $this->assertEquals($number, $element->getPrice());
        $this->assertEquals(['price' => $number], $element->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testSetPriceThrowValidateException()
    {
        $element = new Lead;
        $element->setPrice('some string');
    }

    public function testSetStatusId()
    {
        $element = new Lead;

        $number = 10000;
        $element->setStatusId($number);

        $this->assertEquals($number, $element->getStatusId());
        $this->assertEquals(['status_id' => $number], $element->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testSetStatusIdThrowValidateException()
    {
        $element = new Lead;
        $element->setStatusId('some string');
    }

    public function testSetPipelineId()
    {
        $element = new Lead;

        $number = 10000;
        $element->setPipelineId($number);

        $this->assertEquals($number, $element->getPipelineId());
        $this->assertEquals(['pipeline_id' => $number], $element->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testSetPipelineIdThrowValidateException()
    {
        $element = new Lead;
        $element->setPipelineId('some string');
    }

    public function testSetCompanyId()
    {
        $element = new Lead;

        $number = 10000;
        $element->setCompanyId($number);

        $this->assertEquals($number, $element->getCompanyId());
        $this->assertEquals(['linked_company_id' => $number], $element->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testSetCompanyIdThrowValidateException()
    {
        $element = new Lead;
        $element->setCompanyId('some string');
    }

    public function testSetVisitorUid()
    {
        $element = new Lead;
        $string = 'some string';
        $element->setVisitorUid($string);

        $this->assertEquals($string, $element->getVisitorUid());
        $this->assertEquals(['visitor_uid' => $string], $element->toAmo());
    }
}
