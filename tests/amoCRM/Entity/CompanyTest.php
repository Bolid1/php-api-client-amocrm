<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\BaseElement;
use amoCRM\Entity\Company;
use PHPUnit\Framework\TestCase;

/**
 * Class CompanyTest
 * @package Tests\amoCRM\Entity
 * @covers \amoCRM\Entity\Company
 */
final class CompanyTest extends TestCase
{
    public function testInstanceOfBaseElement()
    {
        $this->assertInstanceOf(
            BaseElement::class,
            new Company
        );
    }

    public function testAddLeadId()
    {
        $element = new Company;

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
        $element = new Company;

        $number = 10000;
        $element->addLeadId($number);

        $numbers = [10001, 10002];
        $element->setLeadsId($numbers);

        $this->assertEquals($numbers, $element->getLeadsId());
        $this->assertEquals(['linked_leads_id' => $numbers], $element->toAmo());
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testAddLeadIdThrowInvalidArgument()
    {
        $element = new Company;
        $element->addLeadId('some string');
    }
}
