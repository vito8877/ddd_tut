<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 19:53
 */

namespace tests\unit\entities\Employee;



use app\entities\Employee\Events\EmployeeReinstated;
use PHPUnit\Framework\TestCase;

class EmployeeReinstateTest extends TestCase
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()
            ->archived()
            ->build();

        $this->assertTrue($employee->isArchived());
        $this->assertFalse($employee->isActive());

        $employee->reinstate(new \DateTimeImmutable());

        $this->assertFalse($employee->isArchived());
        $this->assertTrue($employee->isActive());

        $this->assertNotEmpty($statuses = $employee->getStatuses());
        $this->assertTrue(end($statuses)->isActive());

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeReinstated::class, end($events));
    }

    public function testAlreadyReinstated()
    {
        $employee = EmployeeBuilder::instance()
            ->archived()
            ->build();

        $employee->reinstate(new \DateTimeImmutable());

        $this->expectExceptionMessage('Employee is not archived.');

        $employee->reinstate(new \DateTimeImmutable());
    }
}