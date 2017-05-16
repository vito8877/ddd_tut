<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 12:43
 */

namespace app\forms;


use app\services\dto\EmployeeCreateDto;
use yii\base\Model;

class EmployeeCreateForm extends Model
{

    public function getDto()
    {
        $dto = new EmployeeCreateDto();


        return $dto;
    }
}