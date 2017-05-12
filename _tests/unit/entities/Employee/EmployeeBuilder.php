<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 15:56
 */

namespace tests\unit\entities\Employee;


use app\entities\Employee\Address;
use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;
use app\entities\Employee\Name;
use app\entities\Employee\Phone;

class EmployeeBuilder
{
    private $id = 1;
    private $phones = [];
    private $archived = false;

    public function __construct()
    {
        $this->phones[] = new Phone('+39', '123', '1234567');
    }

    public static function instance()
    {
        return new self();
    }

    public function withId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function withPhones(array $phones)
    {
        $this->phones = $phones;
        return $this;
    }

    public function archived()
    {
        $this->archived = true;
        return $this;
    }

    public function build()
    {
        $employee = new Employee(
            new EmployeeId(23),
            new Name('Timoshchuk', 'Vitaly', 'Anatoliyovich'),
            new Address('Ukraine', 'Kievskaya obl', 'm. Kiev', 'proylok Moskowski', '2a', 4),
            $this->phones);

        if ($this->archived) {
            $employee->archive(new \DateTimeImmutable());
        }

        return $employee;
    }
}