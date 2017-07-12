<?php

namespace Tests\amoCRM;

use amoCRM\BaseRequester;
use amoCRM\Entity\Interfaces\Account;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseRequesterTest
 * @package Tests\amoCRM
 * @covers \amoCRM\BaseRequester
 */
final class BaseRequesterTest extends TestCase
{
    const BASE_URL = 'https://test.amocrm.ru';

    /** @var Account */
    private $account;

    public function setUp()
    {
        parent::setUp();
        $this->account = $this->createMock(Account::class);
        $this->account->method('getAddress')->willReturn(self::BASE_URL);
    }

    public function testSendGetRequest()
    {
        list($response, $body) = $this->mockResponse();

        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with($this->equalTo('get'))
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = $this->buildMock($curl);

        $result = $requester->get('/private/api/auth.php', ['type' => 'json']);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @return array
     */
    private function mockResponse()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $body = '{"response":{"auth":true},"server_time":1498126390}';

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($body);

        return [$response, $body];
    }

    /**
     * @param ClientInterface $curl
     * @return BaseRequester
     */
    private function buildMock(ClientInterface $curl)
    {
        $requester = $this->getMockBuilder(BaseRequester::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$this->account, $curl])
            ->setMethods()
            ->getMock();

        /** @var BaseRequester $requester */
        return $requester;
    }

    public function testSendPostRequest()
    {
        list($response, $body) = $this->mockResponse();

        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with($this->equalTo('post'))
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = $this->buildMock($curl);

        $result = $requester->post('/private/api/auth.php', ['type' => 'json']);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @expectedException \amoCRM\Exception\RuntimeException
     */
    public function testExceptionOnAuthFailed()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(401);

        $response->expects($this->never())
            ->method('getBody');

        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = $this->buildMock($curl);

        $requester->get('/private/api/auth.php', ['type' => 'json']);
    }
}
