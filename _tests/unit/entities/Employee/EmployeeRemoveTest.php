<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 19:49
 */

namespace tests\unit\entities\Employee;



use app\entities\Employee\Events\EmployeeRemoved;
use PHPUnit\Framework\TestCase;

class EmployeeRemoveTest extends TestCase
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()
            ->archived()
            ->build();

        $employee->remove();

        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeRemoved::class, end($events));
    }

    public function testNotArchived()
    {
        $employee = EmployeeBuilder::instance()->build();

        $this->expectExceptionMessage('Cannot remove active employee.');

        $employee->remove();
    }
}