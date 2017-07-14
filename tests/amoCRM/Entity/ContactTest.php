<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseElement;
use amoCRM\Entity\Contact;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\Contact
 */
final class ContactTest extends TestCase
{
    public function testInstanceOfBaseElement()
    {
        $this->assertInstanceOf(
            BaseElement::class,
            new Contact
        );
    }

    public function testSetCompanyId()
    {
        $element = new Contact;

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
        $element = new Contact;
        $element->setCompanyId('some string');
    }

    public function testAddLeadId()
    {
        $element = new Contact;

        $number = 10000;
        $element->addLeadId($number);
        $ids = [$number];

        $this->assertEquals(['linked_leads_id' => $ids], $element->toAmo());

        $number = 10002;
        $element->addLeadId($number);
        $ids[] = $number;

        $this->assertEquals(['linked_leads_id' => $ids], $element->toAmo());
    }

    public function testSetLeadsIds()
    {
        $element = new Contact;

        $number = 10000;
        $element->addLeadId($number);

        $numbers = [10001, 10002];
        $element->setLeadsId($numbers);

        $this->assertEquals($numbers, $element->getLeadsId());
        $this->assertEquals(['linked_leads_id' => $numbers], $element->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\ValidateException
     */
    public function testAddLeadIdThrowValidateException()
    {
        $element = new Contact;
        $element->addLeadId('some string');
    }
}
