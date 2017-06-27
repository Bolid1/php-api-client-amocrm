<?php

namespace Tests\amoCRM\Entities\Elements;

use amoCRM\Entities\Elements\BaseElement;
use amoCRM\Entities\Elements\Contact;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactTest
 * @package Tests\amoCRM\Entities\Elements
 * @covers \amoCRM\Entities\Elements\Contact
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

        $this->assertEquals(['linked_company_id' => $number], $element->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testSetCompanyIdThrowInvalidArgument()
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

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testAddLeadIdThrowInvalidArgument()
    {
        $element = new Contact;
        $element->addLeadId('some string');
    }
}
