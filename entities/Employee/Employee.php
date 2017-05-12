<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 14:10
 */

namespace app\entities\Employee;


use app\entities\AggregateRoot;
use app\entities\EventTrait;
use app\entities\Employee\Events\EmployeeCreated;
use yii\db\ActiveRecord;

class Employee extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    private $id;
    private $name;
    private $address;
    private $createDate;
    private $phones = [];
    private $statuses = [];

    public function __construct(EmployeeId $id, Name $name, Address $address, array $phones)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->createDate = new \DateTimeImmutable();
        $this->phones = new Phones($phones);

        $this->addStatus(Status::ACTIVE, $this->createDate);

        $this->recordEvent(new EmployeeCreated($this->id));
    }

    public function rename(Name $name)
    {
        $this->name = $name;
        $this->recordEvent(new Events\EmployeeRenamed($this->id));
    }

    public function changeAddress(Address $address)
    {
        $this->address = $address;
        $this->recordEvent(new Events\EmployeeAddressChanged($this->id));
    }

    public function addPhone(Phone $phone)
    {
        $this->phones->add($phone);
        $this->recordEvent(new Events\EmployeePhoneAdded($this->id, $phone));
    }

    public function removePhone($index)
    {
        $phone = $this->phones->remove($index);
        $this->recordEvent(new Events\EmployeePhoneRemoved($this->id, $phone));
    }

    public function archive(\DateTimeImmutable $date)
    {
        if ($this->isArchived()) {
            throw new \DomainException('Employee is already archived.');
        }

        $this->addStatus(Status::ARCHIVED, $date);
        $this->recordEvent(new Events\EmployeeArchived($this->id, $date));
    }

    public function reinstate(\DateTimeImmutable $date)
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Employee is not archived.');
        }

        $this->addStatus(Status::ACTIVE, $date);
        $this->recordEvent(new Events\EmployeeReinstated($this->id, $date));
    }

    public function remove()
    {
        if (!$this->isArchived()) {
            throw new \DomainException('Cannot remove active employee.');
        }
        $this->recordEvent(new Events\EmployeeRemoved($this->id));
    }

    public function isActive()
    {
        return $this->getCurrentStatus()->isActive();
    }

    public function isArchived()
    {
        return $this->getCurrentStatus()->isArchived();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhones()
    {
        return $this->phones->getAll();
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function getStatuses()
    {
        return $this->statuses;
    }

    private function addStatus($value, \DateTimeImmutable $date)
    {
        $this->statuses[] = new Status($value, $date);
    }

    private function getCurrentStatus() : Status
    {
        return end($this->statuses);
    }

    ############INFRASTRUCTURE#########
    public static function tableName()
    {
        return '{{%ar_employees}}';
    }

    private static $_prototype;
    public static function instantiate($row)
    {
        if (self::$_prototype === null) {
            $class = get_called_class();
            self::$_prototype = unserialize(sprintf('O:%d:"%s":0:{}', strlen($class), $class));
        }
        $object = clone self::$_prototype;
        $object->init();
        return $object;
    }


}























