<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.04.17
 * Time: 15:36
 */

namespace app\entities\Employee\Events;


use app\entities\Employee\EmployeeId;

class EmployeeRemoved
{
    /**
     * @var EmployeeId
     */
    public $employeeId;

    public function __construct(EmployeeId $employeeId)
    {

        $this->employeeId = $employeeId;
    }
}