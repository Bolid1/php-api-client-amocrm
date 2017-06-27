<?php

namespace Tests\amoCRM;

use amoCRM\Account;
use PHPUnit\Framework\TestCase;

/**
 * Class AccountTest
 * @package Tests\amoCRM
 * @covers \amoCRM\Account
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

    public function testCanBeCreatedFromValidSubdomainAndTopLevelDomain()
    {
        $this->assertInstanceOf(
            Account::class,
            new Account('subdomain', Account::TOP_LEVEL_DOMAIN_RU)
        );
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidSubdomain()
    {
        new Account('so');
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidTopLevelDomain()
    {
        new Account('subdomain', 'some string');
    }

    public function testCanSetInvalidTopLevelDomain()
    {
        $account = new Account('subdomain');

        $base_url = 'https://subdomain.amocrm.';

        $this->assertEquals($base_url . Account::TOP_LEVEL_DOMAIN_RU, $account->getAddress());

        $account->setTopLevelDomain(Account::TOP_LEVEL_DOMAIN_COM);
        $this->assertEquals($base_url . Account::TOP_LEVEL_DOMAIN_COM, $account->getAddress());
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCannotSetInvalidTopLevelDomain()
    {
        $account = new Account('subdomain');
        $account->setTopLevelDomain('bar');
    }

    public function testReturnValidAddress()
    {
        $account = new Account('subdomain', Account::TOP_LEVEL_DOMAIN_RU);
        $base_url = 'https://subdomain.amocrm.ru';
        $this->assertEquals($base_url, $account->getAddress());
    }
}
