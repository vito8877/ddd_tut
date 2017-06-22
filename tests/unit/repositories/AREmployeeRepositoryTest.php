<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 20.05.17
 * Time: 12:18
 */

namespace tests\unit\repositories;


use app\repositories\AREmployeeRepository;
use app\tests\_fixtures\EmployeeFixture;
use app\tests\_fixtures\EmployeePhoneFixture;
use app\tests\_fixtures\EmployeeStatusFixture;

class AREmployeeRepositoryTest extends BaseRepositoryTest
{
    public $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'employee' => EmployeeFixture::class,
            'employee_phone' => EmployeePhoneFixture::class,
            'employee_status' => EmployeeStatusFixture::class,
        ]);

        $this->repository = new AREmployeeRepository();
    }
}