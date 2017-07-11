<?php

namespace Tests\amoCRM;

use amoCRM\Interfaces\Account;
use amoCRM\RequesterPromo;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RequesterPromoTest
 * @package Tests\amoCRM
 * @covers \amoCRM\RequesterPromo
 */
final class RequesterPromoTest extends TestCase
{
    const BASE_URL = 'https://www.amocrm.';
    const BASE_PATH = '/api/accounts/domains/';

    public function testSetTopLevelDomainCOM()
    {
        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('post'),
                $this->equalTo(self::BASE_URL . Account::TOP_LEVEL_DOMAIN_COM . self::BASE_PATH)
            )
            ->willReturn($this->createMock(ResponseInterface::class));

        /** @var ClientInterface $curl */
        $requester = new RequesterPromo($curl);
        $requester->setTopLevelDomain(Account::TOP_LEVEL_DOMAIN_COM);

        $requester->post(self::BASE_PATH, ['foo' => 'bar']);
    }

    public function testSetTopLevelDomainDefaultRU()
    {
        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('get'),
                $this->equalTo(self::BASE_URL . Account::TOP_LEVEL_DOMAIN_RU . self::BASE_PATH)
            )
            ->willReturn($this->createMock(ResponseInterface::class));

        /** @var ClientInterface $curl */
        $requester = new RequesterPromo($curl);

        $requester->get(self::BASE_PATH);
    }

    public function testDomains()
    {
        $domain_info = [
            'status' => 'active',
            'subdomain' => 'dev',
            'base_domain' => 'amocrm.ru',
            'account_domain' => 'dev.amocrm.ru',
            'account_type' => 'ru',
            'top_domain' => 'ru',
        ];
        $expected = [$domain_info];

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $body = json_encode(['response' => $expected]);

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($body);

        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('post'),
                $this->equalTo(self::BASE_URL . Account::TOP_LEVEL_DOMAIN_RU . self::BASE_PATH)
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new RequesterPromo($curl);

        $result = $requester->domains($domain_info['subdomain']);
        $this->assertEquals($expected, $result);
    }
}
