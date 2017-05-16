<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 16:06
 */

namespace app\repositories;


use app\entities\Employee\Employee;
use app\entities\Employee\EmployeeId;
use app\entities\Employee\Phone;
use app\entities\Employee\Status;
use yii\db\Connection;
use yii\db\Query;

class SqlEmployeeRepository implements EmployeeRepository
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * SqlEmployeeRepository constructor.
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }


    /**
     * @param EmployeeId $id
     * @return Employee
     * @throws NotFoundException
     */
    public function get(EmployeeId $id)
    {
        $employee = (new Query())->select('*')
            ->from('{{%sql_employees}}')
            ->andWhere(['id' => $id->getId()])
            ->one($this->db);

        if (!$employee) {
            throw new NotFoundException('Employee not found');
        }

        $phones = (new Query())->select('*')
            ->from('{{%sql_employee_phones}}')
            ->andWhere(['employee_id' => $id->getId()])
            ->orderBy('id')
            ->all($this->db);

        $statuses = (new Query())->select('*')
            ->from('{{%sql_employee_statuses}}')
            ->andWhere(['employee_id' => $id->getId()])
            ->orderBy('id')
            ->all($this->db);
    }

    /**
     * @param Employee $employee
     */
    public function add(Employee $employee)
    {
        $this->db->transaction(function () use ($employee) {
            $this->db->createCommand()
                ->insert('{{%sql_employees}}', self::extractEmployeeData($employee))
                ->execute();

        });

        $this->updatePhones($employee);
        $this->updateStatuses($employee);
    }

    /**
     * @param Employee $employee
     */
    public function save(Employee $employee)
    {
        $this->db->transaction(function () use ($employee) {
            $this->db->createCommand()
                ->update('{{%sql_employees}}', self::extractEmployeeData($employee), ['id' => $employee->getId()->getId()])
                ->execute();

        });

        $this->updatePhones($employee);
        $this->updateStatuses($employee);
    }

    /**
     * @param Employee $employee
     */
    public function remove(Employee $employee)
    {
        $this->db->createCommand()
            ->delete('{{%sql_employees}}', ['id' => $employee->getId()->getId()])
            ->execute();
    }

    /**
     * @return EmployeeId
     */
    public function nextId()
    {
        // TODO: Implement nextId() method.
    }

    private static function extractEmployeeData(Employee $employee)
    {
        $statuses = $employee->getStatuses();

        return [
            'id' => $employee->getId()->getId(),
            'create_date' => $employee->getCreateDate()->format('Y-m-d H:i:s'),
            'name_last' => $employee->getName()->getLast(),
            'name_middle' => $employee->getName()->getMiddle(),
            'name_first' => $employee->getName()->getFirst(),
            'address_country' => $employee->getAddress()->getCountry(),
            'address_region' => $employee->getAddress()->getRegion(),
            'address_city' => $employee->getAddress()->getCity(),
            'address_street' => $employee->getAddress()->getStreet(),
            'address_house' => $employee->getAddress()->getHouse(),
            'current_status' => end($statuses)->getValue(),
        ];
    }

    private function updatePhones(Employee $employee)
    {
        $this->db->createCommand()
            ->delete('{{%sql_employee_phones}}', ['employee_id' => $employee->getId()->getId()])
            ->execute();

        if ($employee->getPhones()) {
            $this->db->createCommand()
                ->batchInsert('{{%sql_employee_phones}}', ['employee_id', 'country', 'code', 'number'], array_map(function (Phone $phone) use ($employee) {
                    return [
                        'employee_id' => $employee->getId()->getId(),
                        'country' => $phone->getCountry(),
                        'code' => $phone->getCode(),
                        'number' => $phone->getNumber(),
                    ];
                }, $employee->getPhones()))
                ->execute();
        }
    }

    private function updateStatuses(Employee $employee)
    {
        $this->db->createCommand()
            ->delete('{{%sql_employee_statuses}}', ['employee_id' => $employee->getId()->getId()])
            ->execute();

        if ($employee->getStatuses()) {
            $this->db->createCommand()
                ->batchInsert('{{%sql_employee_statuses}}', ['employee_id', 'value', 'date'], array_map(function (Status $status) use ($employee) {
                    return [
                        'employee_id' => $employee->getId()->getId(),
                        'value' => $status->getValue(),
                        'date' => $status->getDate(),
                    ];
                }, $employee->getStatuses()))
                ->execute();
        }
    }
}