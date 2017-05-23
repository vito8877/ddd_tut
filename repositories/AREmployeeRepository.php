<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 20.05.17
 * Time: 12:10
 */

namespace app\repositories;


use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;
use Ramsey\Uuid\Uuid;

class AREmployeeRepository implements EmployeeRepository
{
    public function get(EmployeeId $id)
    {
        if (!$employee = Employee::findOne($id->getId())) {
            throw new NotFoundException('Employee not found');
        }
        return $employee;
    }


    /**
     * @param Employee $employee
     */
    public function add(Employee $employee)
    {
        if (!$employee->insert()) {
            throw new \RuntimeException('Adding error');
        }
    }

    /**
     * @param Employee $employee
     */
    public function save(Employee $employee)
    {
        if (!$employee->update()) {
            throw new \RuntimeException('Saving error');
        }
    }

    /**
     * @param Employee $employee
     */
    public function remove(Employee $employee)
    {
        if (!$employee->delete()) {
            throw new \RuntimeException('Removing error');
        }

    }

    /**
     * @return EmployeeId
     */
    public function nextId()
    {
        return new EmployeeId(Uuid::uuid4()->toString());
    }
}