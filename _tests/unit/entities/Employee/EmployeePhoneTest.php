<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 19:12
 */

namespace tests\unit\entities\Employee;


use app\entities\Employee\Events\EmployeePhoneAdded;
use app\entities\Employee\Events\EmployeePhoneRemoved;
use app\entities\Employee\Phone;
use PHPUnit\Framework\TestCase;

class EmployeePhoneTest extends TestCase
{
    public function testAdd()
    {
        $employee = EmployeeBuilder::instance()->build();

        $employee->addPhone($phone = new Phone(3, '234', '1111111'));

        $this->assertNotEmpty($phones = $employee->getPhones());
        $this->assertEquals($phone, end($phones));

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeePhoneAdded::class, end($events));
    }

    public function testAddExists()
    {
        $phone = new Phone(3, '234', '1111111');
        $employee = EmployeeBuilder::instance()
            ->withPhones([$phone])
            ->build();

        $this->expectExceptionMessage('Phone already exists.');

        $employee->addPhone($phone);
    }

    public function testRemove()
    {
        $employee = EmployeeBuilder::instance()
            ->withPhones([
                new Phone(3, '234', '1111111'),
                new Phone(3, '234', '1111112')
            ])
            ->build();

        $this->assertCount(2, $employee->getPhones());

        $employee->removePhone(1);
        $this->assertCount(1, $employee->getPhones());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeePhoneRemoved::class, end($events));
    }

    public function testRemoveNonexistent()
    {
        $employee = EmployeeBuilder::instance()->build();

        $this->expectExceptionMessage('Phone not found.');

        $employee->removePhone(42);
    }

    public function testRemoveLast()
    {
        $employee = EmployeeBuilder::instance()
            ->withPhones([
                new Phone(3, '234', '1111111'),
            ])
            ->build();

        $this->expectExceptionMessage('Cannot remove the last phone.');

        $employee->removePhone(0);
    }
}