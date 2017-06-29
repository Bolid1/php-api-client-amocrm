<?php

namespace Tests\amoCRM;

use amoCRM\BaseRequester;
use amoCRM\Interfaces\Account;
use amoCRM\Interfaces\User;
use amoCRM\RequesterUnsorted;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RequesterUnsortedTest
 * @package Tests\amoCRM
 * @covers \amoCRM\RequesterUnsorted
 */
final class RequesterUnsortedTest extends TestCase
{
    /** @var Account */
    private $_account;

    /** @var User */
    private $_user;

    /** @var array */
    private $_data = ['type' => 'json'];

    public function setUp()
    {
        parent::setUp();
        $this->_account = new \amoCRM\Account('test');
        $this->_user = new \amoCRM\User('test@test.test', '098f6bcd4621d373cade4e832627b4f6');
    }

    public function testSendGetRequest()
    {
        list($response, $body) = $this->mockResponse();

        $query = $this->_data;
        $params = [
            RequestOptions::QUERY => $query + $this->_user->getCredentialsAsArray(User::CREDENTIALS_TYPE_UNSORTED),
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
        $requester = new RequesterUnsorted($this->_account, $this->_user, $curl);

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
            RequestOptions::QUERY => $query . '&' . $this->_user->getCredentials(User::CREDENTIALS_TYPE_UNSORTED),
            RequestOptions::FORM_PARAMS => $this->_data,
        ];
        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('post'),
                $this->anything(),
                $this->equalTo($params)
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new RequesterUnsorted($this->_account, $this->_user, $curl);

        $result = $requester->post('test', $this->_data, $query);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    public function testSendPostRequestWithEmptyQuery()
    {
        list($response, $body) = $this->mockResponse();

        $query = '';
        $params = [
            RequestOptions::QUERY => $this->_user->getCredentials(User::CREDENTIALS_TYPE_UNSORTED),
            RequestOptions::FORM_PARAMS => $this->_data,
        ];
        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('post'),
                $this->anything(),
                $this->equalTo($params)
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new RequesterUnsorted($this->_account, $this->_user, $curl);

        $result = $requester->post('test', $this->_data, $query);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    public function testSendPostRequestWithoutQuery()
    {
        list($response, $body) = $this->mockResponse();

        $params = [
            RequestOptions::QUERY => $this->_user->getCredentialsAsArray(User::CREDENTIALS_TYPE_UNSORTED),
            RequestOptions::FORM_PARAMS => $this->_data,
        ];
        $curl = $this->createMock(ClientInterface::class);
        $curl->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('post'),
                $this->anything(),
                $this->equalTo($params)
            )
            ->willReturn($response);

        /** @var ClientInterface $curl */
        $requester = new RequesterUnsorted($this->_account, $this->_user, $curl);

        $result = $requester->post('test', $this->_data);
        $expected = json_decode($body, true);
        $this->assertEquals($expected['response'], $result);
    }

    public function testInstanceOfBaseRequester()
    {
        /** @var ClientInterface $curl */
        $curl = $this->createMock(ClientInterface::class);

        $this->assertInstanceOf(
            BaseRequester::class,
            new RequesterUnsorted($this->_account, $this->_user, $curl)
        );
    }
}
