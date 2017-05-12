<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 19:00
 */

namespace tests\unit\entities\Employee;


use app\entities\Employee\Events\EmployeeArchived;
use PHPUnit\Framework\TestCase;

class EmployeeArchiveTest extends TestCase
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->build();

        $this->assertTrue($employee->isActive());
        $this->assertFalse($employee->isArchived());

        $employee->archive($date = new \DateTimeImmutable());

        $this->assertFalse($employee->isActive());
        $this->assertTrue($employee->isArchived());

        $this->assertNotEmpty($statuses = $employee->getStatuses());
        $this->assertTrue(end($statuses)->isArchived());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeArchived::class, end($events));
    }

    public function testAlreadyArchived()
    {
        $employee = EmployeeBuilder::instance()->archived()->build();

        $this->expectExceptionMessage('Employee is already archived');
        $employee->archive(new \DateTimeImmutable('2011-09-14'));
    }

}