<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entities\Elements;
use PHPUnit\Framework\TestCase;
use amoCRM\Interfaces\Requester;
use amoCRM\Entities\LeadsRequester;
use amoCRM\Entities\ContactsRequester;
use amoCRM\Entities\EntitiesRequesterFactory;

/**
 * Class EntitiesRequesterFactoryTest
 * @package Tests\amoCRM\Entities
 * @covers \amoCRM\Entities\EntitiesRequesterFactory
 */
final class EntitiesRequesterFactoryTest extends TestCase
{
    /** @var Requester */
    private $_requester;

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCreateFailedOnInvalidElementType()
    {
        $fabric = new EntitiesRequesterFactory($this->_requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make('foo')
        );
    }

    public function testCreateLead()
    {
        $fabric = new EntitiesRequesterFactory($this->_requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make(Elements\Lead::TYPE_SINGLE)
        );
    }

    public function testCreateLeads()
    {
        $fabric = new EntitiesRequesterFactory($this->_requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make(Elements\Lead::TYPE_MANY)
        );
    }

    public function testCreateContact()
    {
        $fabric = new EntitiesRequesterFactory($this->_requester);
        $this->assertInstanceOf(
            ContactsRequester::class,
            $fabric->make(Elements\Contact::TYPE_SINGLE)
        );
    }

    public function testCreateContacts()
    {
        $fabric = new EntitiesRequesterFactory($this->_requester);
        $this->assertInstanceOf(
            ContactsRequester::class,
            $fabric->make(Elements\Contact::TYPE_MANY)
        );
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_requester = $this->createMock(Requester::class);
    }
}
