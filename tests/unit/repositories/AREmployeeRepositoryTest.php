<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 20.05.17
 * Time: 12:18
 */

namespace app\tests\unit\repositories;


use app\repositories\AREmployeeRepository;
use tests\unit\repositories\BaseRepositoryTest;
use UnitTester;

class AREmployeeRepositoryTest extends BaseRepositoryTest
{
    public $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'employee' => EmployeeFixure::class,
            'employee_phone' => EmployeePhoneFixure::class,
            'employee_status' => EmployeeStatusFixure::class,
        ]);

        $this->repository = new AREmployeeRepository();
    }
}