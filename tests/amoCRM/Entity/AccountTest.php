<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\Account;
use PHPUnit\Framework\TestCase;

/**
 * Class AccountTest
 * @package Tests\amoCRM
 * @coversDefaultClass \amoCRM\Entity\Account
 */
final class AccountTest extends TestCase
{
    public function testCanBeCreatedFromValidSubdomain()
    {
        $this->assertInstanceOf(
            Account::class,
            new Account('subdomain')
        );
    }

    /**
     * @covers ::__construct
     */
    public function testCanBeCreatedFromValidSubdomainAndTopLevelDomain()
    {
        $this->assertInstanceOf(
            Account::class,
            new Account('subdomain', Account::TOP_LEVEL_DOMAIN_RU)
        );
    }

    /**
     * @covers ::ensureIsValidSubdomain
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidSubdomain()
    {
        new Account('so');
    }

    /**
     * @covers ::setTopLevelDomain
     * @covers ::ensureIsValidSubdomain
     */
    public function testSetTopLevelDomain()
    {
        $account = new Account('subdomain');

        $base_url = 'https://subdomain.amocrm.';

        $this->assertEquals($base_url . Account::TOP_LEVEL_DOMAIN_RU, $account->getAddress());

        $account->setTopLevelDomain(Account::TOP_LEVEL_DOMAIN_COM);
        $this->assertEquals($base_url . Account::TOP_LEVEL_DOMAIN_COM, $account->getAddress());
    }

    /**
     * @covers ::ensureIsValidTopLevelDomain
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testCannotSetInvalidTopLevelDomain()
    {
        $account = new Account('subdomain');
        $account->setTopLevelDomain('bar');
    }

    /**
     * @covers ::getAddress
     */
    public function testReturnValidAddress()
    {
        $account = new Account('subdomain', Account::TOP_LEVEL_DOMAIN_RU);
        $base_url = 'https://subdomain.amocrm.ru';
        $this->assertEquals($base_url, $account->getAddress());
    }

    /**
     * @covers ::getSubdomain
     * @covers ::setSubdomain
     */
    public function testGetSubdomain()
    {
        $subdomain = 'subdomain';
        $account = new Account($subdomain, Account::TOP_LEVEL_DOMAIN_RU);
        $this->assertEquals($subdomain, $account->getSubdomain());
    }
}
