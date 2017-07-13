<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\Account;
use PHPUnit\Framework\TestCase;

/**
 * Class AccountTest
 * @package Tests\amoCRM
 */
final class AccountTest extends TestCase
{
    /**
     * @covers \amoCRM\Entity\Account::__construct
     * @covers \amoCRM\Entity\Account::ensureIsValidSubdomain
     * @uses   \amoCRM\Entity\Account::ensureIsValidTopLevelDomain
     * @uses   \amoCRM\Entity\Account::setSubdomain
     * @uses   \amoCRM\Entity\Account::setTopLevelDomain
     */
    public function testCanBeCreatedFromValidSubdomainAndTopLevelDomain()
    {
        $this->assertInstanceOf(
            Account::class,
            new Account('subdomain', Account::TOP_LEVEL_DOMAIN_RU)
        );
    }

    /**
     * @covers \amoCRM\Entity\Account::ensureIsValidSubdomain
     * @uses   \amoCRM\Entity\Account::__construct
     * @uses   \amoCRM\Entity\Account::setSubdomain
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidSubdomain()
    {
        new Account('so');
    }

    /**
     * @covers \amoCRM\Entity\Account::setTopLevelDomain
     * @covers \amoCRM\Entity\Account::getTopLevelDomain
     * @uses   \amoCRM\Entity\Account::ensureIsValidSubdomain
     * @uses   \amoCRM\Entity\Account::__construct
     * @uses   \amoCRM\Entity\Account::ensureIsValidTopLevelDomain
     * @uses   \amoCRM\Entity\Account::setSubdomain
     */
    public function testSetTopLevelDomain()
    {
        $account = new Account('subdomain');

        $this->assertEquals(Account::TOP_LEVEL_DOMAIN_RU, $account->getTopLevelDomain());
        $account->setTopLevelDomain(Account::TOP_LEVEL_DOMAIN_COM);
        $this->assertEquals(Account::TOP_LEVEL_DOMAIN_COM, $account->getTopLevelDomain());
    }

    /**
     * @covers \amoCRM\Entity\Account::ensureIsValidTopLevelDomain
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     * @uses   \amoCRM\Entity\Account::__construct
     * @uses   \amoCRM\Entity\Account::ensureIsValidSubdomain
     * @uses   \amoCRM\Entity\Account::setSubdomain
     * @uses   \amoCRM\Entity\Account::setTopLevelDomain
     */
    public function testCannotSetInvalidTopLevelDomain()
    {
        $account = new Account('subdomain');
        $account->setTopLevelDomain('bar');
    }

    /**
     * @covers \amoCRM\Entity\Account::getAddress
     * @uses   \amoCRM\Entity\Account::__construct
     * @uses   \amoCRM\Entity\Account::ensureIsValidSubdomain
     * @uses   \amoCRM\Entity\Account::ensureIsValidTopLevelDomain
     * @uses   \amoCRM\Entity\Account::setSubdomain
     * @uses   \amoCRM\Entity\Account::setTopLevelDomain
     */
    public function testReturnValidAddress()
    {
        $account = new Account('subdomain', Account::TOP_LEVEL_DOMAIN_RU);
        $base_url = 'https://subdomain.amocrm.ru';
        $this->assertEquals($base_url, $account->getAddress());
    }

    /**
     * @covers \amoCRM\Entity\Account::getSubdomain
     * @covers \amoCRM\Entity\Account::setSubdomain
     * @uses   \amoCRM\Entity\Account::__construct
     * @uses   \amoCRM\Entity\Account::ensureIsValidSubdomain
     * @uses   \amoCRM\Entity\Account::ensureIsValidTopLevelDomain
     * @uses   \amoCRM\Entity\Account::setTopLevelDomain
     */
    public function testGetSubdomain()
    {
        $subdomain = 'subdomain';
        $account = new Account($subdomain, Account::TOP_LEVEL_DOMAIN_RU);
        $this->assertEquals($subdomain, $account->getSubdomain());
    }
}
