<?php

namespace Tests\amoCRM\Service;

use amoCRM\Entity\Interfaces\Account;
use amoCRM\Entity\Interfaces\User;
use amoCRM\Service\BaseRequesterService;
use amoCRM\Service\UnsortedRequesterService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RequesterUnsortedTest
 * @package Tests\amoCRM
 * @covers \amoCRM\Service\UnsortedRequesterService
 */
final class UnsortedRequesterServiceTest extends TestCase
{
    /** @var Account */
    private $account;

    /** @var User */
    private $user;

    /** @var array */
    private $data = ['type' => 'json'];

    public function setUp()
    {
        parent::setUp();
        $this->account = new \amoCRM\Entity\Account('test');
        $this->user = new \amoCRM\Entity\User('test@test.test', '098f6bcd4621d37312344e832627b4f6');
    }

    public function testSendGetRequest()
    {
        list($response, $body) = $this->mockResponse();

        $query = $this->data;
        $user_credentials = $this->user->getCredentialsAsArray(User::CREDENTIALS_TYPE_UNSORTED);
        $params = [
            RequestOptions::QUERY => array_merge($query, $user_credentials),
        ];
        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('get'),
                $this->anything(),
                $this->equalTo($params)
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new UnsortedRequesterService($this->account, $this->user, $curl);

        $result = $requester->get('test', $query);
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

        $response
            ->method('getBody')
            ->willReturn($body);

        return [$response, $body];
    }

    public function testSendPostRequest()
    {
        list($response, $body) = $this->mockResponse();


        $query = 'foo=bar';
        $params = [
            RequestOptions::QUERY => $query . '&' . $this->user->getCredentials(User::CREDENTIALS_TYPE_UNSORTED),
            RequestOptions::FORM_PARAMS => $this->data,
        ];
        $curl = $this->buildPostCurl($params, $response);

        /** @var ClientInterface $curl */
        $requester = new UnsortedRequesterService($this->account, $this->user, $curl);

        $result = $requester->post('test', $this->data, $query);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    /**
     * @param array $params
     * @param ResponseInterface $response
     * @return ClientInterface
     */
    private function buildPostCurl($params, ResponseInterface $response)
    {
        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('post'),
                $this->anything(),
                $this->equalTo($params)
            )
            ->willReturn($response);

        return $curl;
    }

    public function testSendPostRequestWithEmptyQuery()
    {
        list($response, $body) = $this->mockResponse();

        $query = '';
        $params = [
            RequestOptions::QUERY => $this->user->getCredentials(User::CREDENTIALS_TYPE_UNSORTED),
            RequestOptions::FORM_PARAMS => $this->data,
        ];
        $curl = $this->buildPostCurl($params, $response);

        /** @var ClientInterface $curl */
        $requester = new UnsortedRequesterService($this->account, $this->user, $curl);

        $result = $requester->post('test', $this->data, $query);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    public function testSendPostRequestWithoutQuery()
    {
        list($response, $body) = $this->mockResponse();

        $params = [
            RequestOptions::QUERY => $this->user->getCredentialsAsArray(User::CREDENTIALS_TYPE_UNSORTED),
            RequestOptions::FORM_PARAMS => $this->data,
        ];
        $curl = $this->buildPostCurl($params, $response);

        /** @var ClientInterface $curl */
        $requester = new UnsortedRequesterService($this->account, $this->user, $curl);

        $result = $requester->post('test', $this->data);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    public function testInstanceOfBaseRequester()
    {
        /** @var ClientInterface $curl */
        $curl = $this->createMock(ClientInterface::class);

        $this->assertInstanceOf(
            BaseRequesterService::class,
            new UnsortedRequesterService($this->account, $this->user, $curl)
        );
    }
}
