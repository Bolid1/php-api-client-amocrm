<?php

namespace Tests\amoCRM;

use amoCRM\Interfaces\Account;
use amoCRM\Interfaces\User;
use amoCRM\Requester;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RequesterTest
 * @package Tests\amoCRM
 * @covers \amoCRM\Requester
 */
final class RequesterTest extends TestCase
{
    const BASE_URL = 'https://test.amocrm.ru';
    const CREDENTIALS = [
        'USER_LOGIN' => 'test@test.test',
        'USER_HASH' => '098f6bcd4621d373cade4e832627b4f6',
    ];

    /** @var Account */
    private $_account;

    /** @var User */
    private $_user;

    public function setUp()
    {
        parent::setUp();
        $this->_account = $this->createMock(Account::class);
        $this->_account->method('getAddress')->willReturn(self::BASE_URL);

        $this->_user = $this->createMock(User::class);
        $this->_user->method('getCredentials')->willReturn(http_build_query(self::CREDENTIALS));
        $this->_user->method('getCredentialsAsArray')->willReturn(self::CREDENTIALS);
    }

    public function testSendGetRequest()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn('{"response":{"auth":true},"server_time":1498126390}');
        /** @var ResponseInterface $response */

        $curl = $this->createMock(ClientInterface::class);
        $curl->method('request')->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $result = $requester->get('/private/api/auth.php', ['type' => 'json']);
        $expected = json_decode($response->getBody(), true);
        $this->assertEquals($expected['response'], $result);
    }

    public function testSendPostRequest()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn('{"response":{"auth":true},"server_time":1498126390}');
        /** @var ResponseInterface $response */

        $curl = $this->createMock(ClientInterface::class);
        $curl->method('request')->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $result = $requester->post('/private/api/auth.php', ['type' => 'json']);
        $expected = json_decode($response->getBody(), true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @expectedException \amoCRM\Exceptions\RuntimeException
     */
    public function testExceptionOnAuthFailed()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn('{"response":{"auth":false},"server_time":1498126390}');
        /** @var ResponseInterface $response */

        $curl = $this->createMock(ClientInterface::class);
        $curl->method('request')->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $requester->get('/private/api/auth.php', ['type' => 'json']);
    }
}
