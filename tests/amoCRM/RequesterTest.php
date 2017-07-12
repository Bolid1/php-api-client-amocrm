<?php

namespace Tests\amoCRM;

use amoCRM\BaseRequester;
use amoCRM\Entity\Interfaces\Account;
use amoCRM\Entity\Interfaces\User;
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
        'USER_HASH' => '098f6bcd4621d37345674e832627b4f6',
    ];

    /** @var Account */
    private $account;

    /** @var User */
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->account = $this->createMock(Account::class);
        $this->account->method('getAddress')->willReturn(self::BASE_URL);

        $this->user = $this->createMock(User::class);
        $this->user->method('getCredentials')->willReturn(http_build_query(self::CREDENTIALS));
        $this->user->method('getCredentialsAsArray')->willReturn(self::CREDENTIALS);
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
        $requester = new Requester($this->account, $this->user, $curl);

        $result = $requester->get('test', ['type' => 'json']);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @param int $usage_count
     * @return array
     */
    private function mockResponse($usage_count = 1)
    {
        $response = $this->createMock(ResponseInterface::class);
        // Let's include auth response
        ++$usage_count;
        $response->expects($this->exactly($usage_count))
            ->method('getStatusCode')
            ->willReturn(200);

        $body = '{"response":{"auth":true},"server_time":1498126390}';

        $response
            ->method('getBody')
            ->willReturn($body);

        return [$response, $body];
    }

    public function testSlowDown()
    {
        $repeats_count = 3;

        list($response) = $this->mockResponse($repeats_count);
        $curl = $this->createMock(ClientInterface::class);
        $curl->method('request')
            ->willReturn($response);

        $requester = new Requester($this->account, $this->user, $curl);

        $start = microtime(true);
        for ($i = 0; $i < $repeats_count; ++$i) {
            $requester->get('test', ['type' => 'json']);
        }

        $end = microtime(true) - $start;

        $delta = $end - $repeats_count;
        // Ensure, that we spend $repeats_count seconds or greater to make all requests
        $this->assertGreaterThan(0, $delta);
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
        $requester = new Requester($this->account, $this->user, $curl);

        $result = $requester->post('test', ['type' => 'json']);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @expectedException \amoCRM\Exception\RuntimeException
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
        $requester = new Requester($this->account, $this->user, $curl);

        // Now will return 401 and auth must be lost
        $requester->post('/private/api/auth.php', ['type' => 'json']);
    }

    public function testInstanceOfBaseRequester()
    {
        /** @var ClientInterface $curl */
        $curl = $this->createMock(ClientInterface::class);

        $this->assertInstanceOf(
            BaseRequester::class,
            new Requester($this->account, $this->user, $curl)
        );
    }
}
