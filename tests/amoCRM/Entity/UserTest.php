<?php

namespace Tests\amoCRM\Entity;

use amoCRM\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 * @package Tests\amoCRM
 * @covers \amoCRM\Entity\User
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
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidEmailAddress()
    {
        new User('test.test', md5('some string'));
    }

    /**
     * @expectedException \amoCRM\Exception\InvalidArgumentException
     */
    public function testCannotBeCreatedFromInvalidAPIKey()
    {
        new User('test@test.test', 'some string');
    }

    public function testReturnValidAPICredentials()
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

    public function testReturnValidAPICredentialsArray()
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

    public function testReturnValidUnsortedCredentials()
    {
        $login = 'test@test.test';
        $api_key = md5('some string');
        $user = new User($login, $api_key);

        $credentials = [
            'login' => $login,
            'api_key' => $api_key,
        ];
        $this->assertEquals(http_build_query($credentials), $user->getCredentials(User::CREDENTIALS_TYPE_UNSORTED));
    }

    public function testReturnValidUnsortedCredentialsArray()
    {
        $login = 'test@test.test';
        $api_key = md5('some string');
        $user = new User($login, $api_key);

        $credentials = [
            'login' => $login,
            'api_key' => $api_key,
        ];
        $this->assertEquals($credentials, $user->getCredentialsAsArray(User::CREDENTIALS_TYPE_UNSORTED));
    }
}
