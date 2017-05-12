<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 18:25
 */

namespace tests\unit\entities\Employee;


use app\entities\Employee\Address;
use app\entities\Employee\Events\EmployeeAddressChanged;
use PHPUnit\Framework\TestCase;

class EmployeeChangeAddressTest extends TestCase
{
    public function testSuccess()
    {
        $employee = EmployeeBuilder::instance()->build();

        $employee->changeAddress($address = new Address('New', 'Test', 'Address', 'Street', '2a'));

        $this->assertEquals($address, $employee->getAddress());
        $this->assertNotEmpty($events = $employee->releaseEvents());
        $this->assertInstanceOf(EmployeeAddressChanged::class, end($events));
    }
}