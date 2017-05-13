<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 13.05.17
 * Time: 2:19
 */

namespace tests\unit\repositories;


use app\entities\Employee\EmployeeId;
use app\repositories\EmployeeRepository;
use app\repositories\NotFoundException;
use Codeception\Test\Unit;
use tests\unit\entities\Employee\EmployeeBuilder;

class BaseRepositoryTest extends Unit
{
    /**
     * @var EmployeeRepository
     */
    protected $repository;

    public function testGet()
    {
        $this->repository->add($employee = EmployeeBuilder::instance()->build());
        $found = $this->repository->get($employee->getId());

        $this->assertNotNull($found);
        $this->assertEquals($employee->getId(), $found->getId());
    }

    public function testGetNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->repository->get(new EmployeeId(25));
    }
}