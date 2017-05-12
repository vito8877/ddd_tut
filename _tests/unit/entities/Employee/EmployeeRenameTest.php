<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 18:13
 */

namespace tests\unit\entities\Employee;


use app\entities\Employee\Events\EmployeeRenamed;
use app\entities\Employee\Name;
use PHPUnit\Framework\TestCase;

class EmployeeRenameTest extends TestCase
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->build();

        $employee->rename($name = new Name('New', 'Test', 'Name'));
        $this->assertEquals($name, $employee->getName());
        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeRenamed::class, end($events));
    }
}