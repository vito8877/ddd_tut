<?php

namespace tests\unit\models;


use app\models\User;
use PHPUnit\Framework\TestCase;


class SaveTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        User::deleteAll();
    }

    public function testSaveIntoDb()
    {
        $user = new User([
            'username' => 'TestUserName',
            'email' => 'test@gmail.com',
            'id' => 23,
        ]);

        $this->assertTrue($user->save(), 'Model saved');
    }
}



