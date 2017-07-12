<?php

namespace Tests\amoCRM\Entities;

use amoCRM\Entities\ContactsRequester;
use amoCRM\Entities\EntitiesRequesterFactory;
use amoCRM\Entities\LeadsRequester;
use amoCRM\Entity;
use amoCRM\Interfaces\Requester;
use PHPUnit\Framework\TestCase;

/**
 * Class EntitiesRequesterFactoryTest
 * @package Tests\amoCRM\Entities
 * @covers \amoCRM\Entities\EntitiesRequesterFactory
 */
final class EntitiesRequesterFactoryTest extends TestCase
{
    /** @var Requester */
    private $requester;

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCreateFailedOnInvalidElementType()
    {
        $fabric = new EntitiesRequesterFactory($this->requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make('foo')
        );
    }

    public function testCreateLead()
    {
        $fabric = new EntitiesRequesterFactory($this->requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make(Entity\Lead::TYPE_SINGLE)
        );
    }

    public function testCreateLeads()
    {
        $fabric = new EntitiesRequesterFactory($this->requester);
        $this->assertInstanceOf(
            LeadsRequester::class,
            $fabric->make(Entity\Lead::TYPE_MANY)
        );
    }

    public function testCreateContact()
    {
        $fabric = new EntitiesRequesterFactory($this->requester);
        $this->assertInstanceOf(
            ContactsRequester::class,
            $fabric->make(Entity\Contact::TYPE_SINGLE)
        );
    }

    public function testCreateContacts()
    {
        $fabric = new EntitiesRequesterFactory($this->requester);
        $this->assertInstanceOf(
            ContactsRequester::class,
            $fabric->make(Entity\Contact::TYPE_MANY)
        );
    }

    protected function setUp()
    {
        parent::setUp();
        $this->requester = $this->createMock(Requester::class);
    }
}
