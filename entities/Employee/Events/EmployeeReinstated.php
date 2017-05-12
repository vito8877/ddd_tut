<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 19.04.17
 * Time: 23:38
 */

namespace app\entities\Employee\Events;


use app\entities\Employee\EmployeeId;

class EmployeeReinstated
{
    /**
     * @var EmployeeId
     */
    private $employeeId;
    /**
     * @var \DateTimeImmutable
     */
    private $date;

    public function __construct(EmployeeId $employeeId, \DateTimeImmutable $date)
    {

        $this->employeeId = $employeeId;
        $this->date = $date;
    }
}