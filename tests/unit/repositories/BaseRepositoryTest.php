<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 13.05.17
 * Time: 2:19
 */

namespace tests\unit\repositories;


use app\entities\Employee\EmployeeId;
use app\entities\Employee\Name;
use app\entities\Employee\Phone;
use app\entities\Employee\Status;
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

    public function testAdd()
    {
        $employee = EmployeeBuilder::instance()->withPhones([
            new Phone(7, '888', '0000001'),
            new Phone(7, '888', '0000002'),
        ])->build();

        $this->repository->add($employee);

        $found = $this->repository->get($employee->getId());

        $this->assertEquals($employee->getId(), $found->getId());
        $this->assertEquals($employee->getName(), $found->getName());
        $this->assertEquals($employee->getAddress(), $found->getAddress());
        $this->assertEquals($employee->getCreateDate()->getTimestamp(), $found->getCreateDate()->getTimestamp());

        $this->checkPhones($employee->getPhones(), $found->getPhones());
        $this->checkStatuses($employee->getStatuses(), $found->getStatuses());
    }

    public function testUpdate()
    {
        $employee = EmployeeBuilder::instance()->withPhones([
            new Phone(7, '888', '0000001'),
            new Phone(7, '888', '0000002'),
        ])->build();

        $this->repository->add($employee);
        $edit = $this->repository->get($employee->getId());

        $edit->rename($name = new Name('New', 'Test', 'Name'));
        $edit->addPhone($phone = new Phone(7, '888', '0000003'));
        $edit->archive(new \DateTimeImmutable());

        $this->repository->save($edit);

        $found = $this->repository->get($employee->getId());

        $this->assertTrue($found->isArchived());
        $this->assertEquals($name, $found->getName());

        $this->checkPhones($edit->getPhones(), $found->getPhones());
        $this->checkStatuses($edit->getStatuses(), $found->getStatuses());
    }

    public function testRemove()
    {
        $employee = EmployeeBuilder::instance()->withId(5)->build();
        $this->repository->add($employee);
        $this->repository->remove($employee);
        $this->expectException(NotFoundException::class);
        $this->repository->get(new EmployeeId(5));
    }

    private function checkPhones(array $expected, array $actual)
    {
        $phoneData = function (Phone $phone) {
            return $phone->getFull();
        };

        $this->assertEquals(
            array_map($phoneData, $expected),
            array_map($phoneData, $actual)
        );
    }

    private function checkStatuses(array $expected, array $actual)
    {
        $statusData = function (Status $status) {
            return [
                'value' => $status->getValue(),
                'data' => $status->getDate()->getTimestamp(),
            ];
        };

        $this->assertEquals(
            array_map($statusData, $expected),
            array_map($statusData, $actual)
        );
    }
}