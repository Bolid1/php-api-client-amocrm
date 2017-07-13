<?php

namespace Tests\amoCRM\Repository\Factory;

use amoCRM\Entity;
use amoCRM\Repository\ContactsRepository;
use amoCRM\Repository\Factory\EntitiesRepositoryFactory;
use amoCRM\Repository\LeadsRepository;
use amoCRM\Service\Interfaces\RequesterService;
use PHPUnit\Framework\TestCase;

/**
 * Class EntitiesRepositoryFactoryTest
 * @package Tests\amoCRM\Entities
 * @covers \amoCRM\Repository\Factory\EntitiesRepositoryFactory
 */
final class EntitiesRepositoryFactoryTest extends TestCase
{
    /** @var RequesterService */
    private $requester;

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testCreateFailedOnInvalidElementType()
    {
        $fabric = new EntitiesRepositoryFactory($this->requester);
        $this->assertInstanceOf(
            LeadsRepository::class,
            $fabric->make('foo')
        );
    }

    public function testCreateLead()
    {
        $fabric = new EntitiesRepositoryFactory($this->requester);
        $this->assertInstanceOf(
            LeadsRepository::class,
            $fabric->make(Entity\Lead::TYPE_SINGLE)
        );
    }

    public function testCreateLeads()
    {
        $fabric = new EntitiesRepositoryFactory($this->requester);
        $this->assertInstanceOf(
            LeadsRepository::class,
            $fabric->make(Entity\Lead::TYPE_MANY)
        );
    }

    public function testCreateContact()
    {
        $fabric = new EntitiesRepositoryFactory($this->requester);
        $this->assertInstanceOf(
            ContactsRepository::class,
            $fabric->make(Entity\Contact::TYPE_SINGLE)
        );
    }

    public function testCreateContacts()
    {
        $fabric = new EntitiesRepositoryFactory($this->requester);
        $this->assertInstanceOf(
            ContactsRepository::class,
            $fabric->make(Entity\Contact::TYPE_MANY)
        );
    }

    protected function setUp()
    {
        parent::setUp();
        $this->requester = $this->createMock(RequesterService::class);
    }
}
