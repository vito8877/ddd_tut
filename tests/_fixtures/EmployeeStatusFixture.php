<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 23.05.17
 * Time: 23:51
 */

namespace app\tests\_fixtures;


use yii\test\ActiveFixture;

class EmployeeStatusFixture extends ActiveFixture
{
    public $tableName = '{{%ar_employee_statuses}}';
    public $dataFile = '@tests/_fixtures/data/ar_employee_statuses.php';
}