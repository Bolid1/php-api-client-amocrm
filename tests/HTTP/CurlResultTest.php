<?php

namespace Libs\Helpers\HTTP;

use HTTP\CurlResult;
use PHPUnit\Framework\TestCase;

/**
 * Class CurlResultTest
 * @package Tests\amoCRM
 * @covers \HTTP\CurlResult
 */
final class CurlResultTest extends TestCase
{
    public function testGetInfo()
    {
        $info = ['foo' => 'bar'];
        $result = new CurlResult('', $info);

        $this->assertEquals($info, $result->getInfo());
        $this->assertEquals(reset($info), $result->getInfo(key($info)));
    }

    public function testGetBody()
    {
        $body = 'test body';
        $result = new CurlResult($body, []);

        $this->assertEquals($body, $result->getBody());
    }

    public function testGetBodyFromJSON()
    {
        $body = '{"foo":"bar"}';
        $result = new CurlResult($body, []);

        $this->assertEquals(['foo' => 'bar'], $result->getBodyFromJSON());
        $this->assertEquals('bar', $result->getBodyFromJSON('foo'));
    }

    /**
     * @expectedException \HTTP\Exceptions\InvalidArgumentException
     */
    public function testGetBodyFromJSONException()
    {
        $body = 'test body';
        $result = new CurlResult($body, []);

        $result->getBodyFromJSON();
    }
}
