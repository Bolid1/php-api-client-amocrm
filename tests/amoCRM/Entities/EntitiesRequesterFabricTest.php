<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entities\ContactsRequester;
use amoCRM\Entities\EntitiesRequesterFabric;
use amoCRM\Entities\LeadsRequester;
use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

/**
 * Class EntitiesRequesterFabricTest
 * @package Tests\amoCRM\Entities
 * @covers \amoCRM\Entities\EntitiesRequesterFabric
 */
final class EntitiesRequesterFabricTest extends TestCase
{
    /** @var Requester */
    private $_requester;

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCreateFailedOnInvalidElementType()
    {
        $fabric = new EntitiesRequesterFabric($this->_requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make('foo')
        );
    }

    public function testCreateLead()
    {
        $fabric = new EntitiesRequesterFabric($this->_requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make('lead')
        );
    }

    public function testCreateLeads()
    {
        $fabric = new EntitiesRequesterFabric($this->_requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make('leads')
        );
    }

    public function testCreateContact()
    {
        $fabric = new EntitiesRequesterFabric($this->_requester);
        $this->assertInstanceOf(
            ContactsRequester::class,
            $fabric->make('contact')
        );
    }

    public function testCreateContacts()
    {
        $fabric = new EntitiesRequesterFabric($this->_requester);
        $this->assertInstanceOf(
            ContactsRequester::class,
            $fabric->make('contacts')
        );
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_requester = $this->createMock(Requester::class);
    }
}
