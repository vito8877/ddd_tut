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
use app\repositories\InstantiateTrait;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;

class Employee extends ActiveRecord implements AggregateRoot
{
    use EventTrait, InstantiateTrait;

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

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['relatedPhones', 'relatedStatuses'],
            ]
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


    public function afterFind()
    {
        $this->id = new EmployeeId(
            $this->getAttribute('employee_id')
        );

        $this->name = new Name(
            $this->getAttribute('employee_name_last'),
            $this->getAttribute('employee_name_first'),
            $this->getAttribute('employee_name_middle')
        );

        $this->address = new Address(
            $this->getAttribute('employee_address_country'),
            $this->getAttribute('employee_address_region'),
            $this->getAttribute('employee_address_city'),
            $this->getAttribute('employee_address_street'),
            $this->getAttribute('employee_address_house')
        );

        $this->createDate = new \DateTimeImmutable(
            $this->getAttributeHint('employee_create_date')
        );

        $this->phones = new Phones($this->relatedPhones);
        $this->statuses = $this->relatedStatuses;

        parent::afterFind();
    }

    public function getRelatedPhones()
    {
        return $this->hasMany(Phone::class, ['phone_employee_id' => 'employee_id'])->orderBy('phone_id');
    }

    public function getRelatedStatuses()
    {
        return $this->hasMany(Status::class, ['status_employee_id' => 'employee_id'])->orderBy('status_id');
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('employee_id', $this->id->getId());

        $this->setAttribute('employee_name_last', $this->name->getLast());
        $this->setAttribute('employee_name_first', $this->name->getFirst());
        $this->setAttribute('employee_name_middle', $this->name->getMIddle());

        $this->setAttribute('employee_address_country', $this->address->getCountry());
        $this->setAttribute('employee_address_region', $this->address->getRegion());
        $this->setAttribute('employee_address_city', $this->address->getCity());
        $this->setAttribute('employee_address_street', $this->address->getStreet());
        $this->setAttribute('employee_address_house', $this->address->getHouse());

        $this->setAttribute('employee_create_date', $this->getCreateDate()->format('Y-m-d H:i:s'));

        $this->setAttribute('employee_current_status', $this->getCurrentStatus()->getValue());

        return parent::beforeSave($insert);
    }


}























