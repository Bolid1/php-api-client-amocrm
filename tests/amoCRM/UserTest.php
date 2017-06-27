<?php

namespace Tests\amoCRM;

use amoCRM\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 * @package Tests\amoCRM
 * @covers \amoCRM\User
 */
final class UserTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAndHash()
    {
        $this->assertInstanceOf(
            User::class,
            new User('test@test.test', md5('some string'))
        );
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidEmailAddress()
    {
        new User('test.test', md5('some string'));
    }

    /**
     * @expectedException \amoCRM\Exceptions\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidAPIKey()
    {
        new User('test@test.test', 'some string');
    }

    public function testReturnValidCredentials()
    {
        $login = 'test@test.test';
        $api_key = md5('some string');
        $user = new User($login, $api_key);

        $credentials = [
            'USER_LOGIN' => $login,
            'USER_HASH' => $api_key,
        ];
        $this->assertEquals(http_build_query($credentials), $user->getCredentials());
    }

    public function testReturnValidCredentialsArray()
    {
        $login = 'test@test.test';
        $api_key = md5('some string');
        $user = new User($login, $api_key);

        $credentials = [
            'USER_LOGIN' => $login,
            'USER_HASH' => $api_key,
        ];
        $this->assertEquals($credentials, $user->getCredentialsAsArray());
    }
}
