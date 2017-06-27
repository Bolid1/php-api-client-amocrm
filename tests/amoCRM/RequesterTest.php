<?php

namespace Tests\amoCRM;

use amoCRM\Interfaces\Account;
use amoCRM\Interfaces\User;
use amoCRM\Requester;
use HTTP\CurlResult;
use HTTP\Interfaces\Curl;
use PHPUnit\Framework\TestCase;

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
        $response = '{"response":{"auth":true},"server_time":1498126390}';
        $expected = new CurlResult($response, ['http_code' => 200]);

        $curl = $this->createMock(Curl::class);
        $curl->method('get')->willReturn($expected);
        $curl->method('post')->willThrowException(new \RuntimeException('No need post'));

        /** @var Curl $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $result = $requester->get('/private/api/auth.php', ['type' => 'json']);
        $this->assertEquals($expected->getBodyFromJSON('response'), $result);
    }

    public function testSendPostRequest()
    {
        $response = '{"response":{"auth":true},"server_time":1498126390}';
        $expected = new CurlResult($response, ['http_code' => 200]);

        $curl = $this->createMock(Curl::class);
        $curl->method('get')->willReturn($expected);
        $curl->method('post')->willReturn($expected);

        /** @var Curl $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $result = $requester->post('/private/api/auth.php', ['type' => 'json']);
        $this->assertEquals($expected->getBodyFromJSON('response'), $result);
    }

    /**
     * @expectedException \amoCRM\Exceptions\RuntimeException
     */
    public function testExceptionOnAuthFailed()
    {
        $response = '{"response":{"auth":false},"server_time":1498126390}';
        $expected = new CurlResult($response, ['http_code' => 200]);

        $curl = $this->createMock(Curl::class);
        $curl->method('get')->willReturn($expected);
        $curl->method('post')->willThrowException(new \RuntimeException('No need post'));

        /** @var Curl $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $result = $requester->get('/private/api/auth.php', ['type' => 'json']);
        $this->assertEquals($expected->getBodyFromJSON('response'), $result);
    }
}
