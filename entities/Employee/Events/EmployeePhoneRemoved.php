<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.04.17
 * Time: 15:38
 */

namespace app\entities\Employee\Events;


use app\entities\Employee\EmployeeId;
use app\entities\Employee\Phone;

class EmployeePhoneRemoved
{
    /**
     * @var EmployeeId
     */
    public $employeeId;
    /**
     * @var Phone
     */
    public $phone;

    public function __construct(EmployeeId $employeeId, Phone $phone)
    {

        $this->employeeId = $employeeId;
        $this->phone = $phone;
    }
}