<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 23.05.17
 * Time: 23:43
 */

namespace app\tests\_fixtures;


use yii\test\ActiveFixture;

class EmployeeFixture extends ActiveFixture
{
    public $tableName = '{{%ar_employees}}';
    public $dataFile = '@tests/_fixtures/data/ar_employees.php';
}