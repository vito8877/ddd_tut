<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 13:25
 */

namespace tests\unit\entities\Employee;



use app\entities\Employee\Address;
use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;
use app\entities\Employee\Events\EmployeeCreated;
use app\entities\Employee\Name;
use app\entities\Employee\Phone;
use PHPUnit\Framework\TestCase;

class EmployeeCreationTest extends TestCase
{
    public function testEmployeeCreation()
    {
        $employee = new Employee(
            $id = new EmployeeId(23),
            $name = new Name('Timoshchuk', 'Vitaly', 'Anatoliyovich'),
            $address = new Address('Ukraine', 'Kievskaya obl', 'm. Kiev', 'proylok Moskowski', '2a', 4),
            $phones = [
                new Phone('+39', 'O97', '3588721'),
                new Phone('+39', '123', '1234567'),
            ]
        );

        $this->assertEquals($id, $employee->getId());
        $this->assertEquals($name, $employee->getName());
        $this->assertEquals($address, $employee->getAddress());
        $this->assertEquals($phones, $employee->getPhones());

        $this->assertNotNull($employee->getCreateDate());
        $this->assertTrue($employee->isActive());
        $this->count(1, $employee->getStatuses());
        $statuses = $employee->getStatuses();
        $this->assertTrue(end($statuses)->isActive());
        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeCreated::class, end($events));
    }

    public function testWithoutPhones()
    {
        $this->expectExceptionMessage('Employee must contain at least one phone.');

        new Employee(
            new EmployeeId(23),
            new Name('Timoshchuk', 'Vitaly', 'Anatoliyovich'),
            new Address('Ukraine', 'Kievskaya obl', 'm. Kiev', 'proylok Moskowski', '2a', 4),
            []);
    }

    public function testWithSamePhoneNumbers()
    {
        $this->expectExceptionMessage('Phone already exists.');

        new Employee(
            new EmployeeId(23),
            new Name('Timoshchuk', 'Vitaly', 'Anatoliyovich'),
            new Address('Ukraine', 'Kievskaya obl', 'm. Kiev', 'proylok Moskowski', '2a', 4),
            [
                new Phone('+39', 'O97', '3588721'),
                new Phone('+39', 'O97', '3588721'),
            ]
        );
    }
}