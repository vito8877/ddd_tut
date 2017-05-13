<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 13.05.17
 * Time: 9:59
 */

namespace tests\unit\repositories;


class MemoryEmployeeRepositoryTest extends BaseRepositoryTest
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function _before()
    {
        $this->repository = new MemoryEmployeeREpository();
    }
}