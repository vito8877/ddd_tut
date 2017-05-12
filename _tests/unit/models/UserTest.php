<?php

namespace tests\unit\models;



use app\models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testValidateEmptyValues()
    {
        $user = new User();

        $this->assertFalse($user->validate(), 'validate empty username and email');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check empty username error');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check empty email error');
        $this->assertArrayHasKey('id', $user->getErrors(), 'check empty id error');
    }

    public function testValidateWrongValues()
    {
        $user = new User([
            'username' => 'wrong $ username',
            'email'    => 'wrong * email',
            'id'    => 'wrong id',
        ]);

        $this->assertFalse($user->validate(), 'validate wrong username and email');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check wrong username error');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check wrong email error');
        $this->assertArrayHasKey('id', $user->getErrors(), 'check wrong id error');
    }

    public function testCorrectValues()
    {
        $user = new User([
            'username' => 'CorrectUsername',
            'email' => 'correct@email.com',
            'id' => 34,
        ]);

        $this->assertTrue($user->validate(), 'user passed validation');
    }
}




