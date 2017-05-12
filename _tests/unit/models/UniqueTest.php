<?php

namespace tests\unit\models;


use app\models\User;
use PHPUnit\Framework\TestCase;
use Yii;



class UniqueTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        User::deleteAll();

        Yii::$app->db->createCommand()->insert(User::tableName(), [
            'username' => 'user',
            'email' => 'user@email.com',
            'id' => 2,
        ])->execute();
    }

    public function testUniqueValues()
    {
        $user = new User([
            'username' => 'user',
            'email' => 'user@email.com',
            'id' => 2,
        ]);

        $this->assertFalse($user->validate(), 'model is not valid');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check username already exists');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check email already exists');
        $this->assertArrayHasKey('id', $user->getErrors(), 'check id already exists');
    }
}



