<?php

namespace Tests\amoCRM;

use amoCRM\BaseRequester;
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
        list($response, $body) = $this->mockResponse();

        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->exactly(2))
            ->method('request')
            ->with(
                $this->logicalOr(
                    $this->equalTo('get'),
                    $this->stringContains('private/api/auth.php'),
                    $this->equalTo('get'),
                    $this->stringContains('/test')
                )
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $result = $requester->get('test', ['type' => 'json']);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @return array
     */
    private function mockResponse()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->exactly(2))
            ->method('getStatusCode')
            ->willReturn(200);

        $body = '{"response":{"auth":true},"server_time":1498126390}';

        $response
            ->method('getBody')
            ->willReturn($body);

        return [$response, $body];
    }

    public function testSendPostRequest()
    {
        list($response, $body) = $this->mockResponse();

        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->exactly(2))
            ->method('request')
            ->with(
                $this->logicalOr(
                    $this->equalTo('get'),
                    $this->stringContains('private/api/auth.php'),
                    $this->equalTo('post'),
                    $this->stringContains('/test')
                )
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        $result = $requester->post('test', ['type' => 'json']);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @expectedException \amoCRM\Exceptions\RuntimeException
     */
    public function testExceptionOnAuthLost()
    {
        $auth_success = '{"response":{"auth":true},"server_time":1498126390}';

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->exactly(2))
            ->method('getStatusCode')
            ->willReturn(200, 401);

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($auth_success);

        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->exactly(2))
            ->method('request')
            ->with(
                $this->logicalOr(
                    $this->equalTo('get'),
                    $this->stringContains('private/api/auth.php'),
                    $this->equalTo('post'),
                    $this->stringContains('/test')
                )
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new Requester($this->_account, $this->_user, $curl);

        // Now will return 401 and auth must be lost
        $requester->post('/private/api/auth.php', ['type' => 'json']);
    }

    public function testInstanceOfBaseRequester()
    {
        /** @var ClientInterface $curl */
        $curl = $this->createMock(ClientInterface::class);

        $this->assertInstanceOf(
            BaseRequester::class,
            new Requester($this->_account, $this->_user, $curl)
        );
    }
}
