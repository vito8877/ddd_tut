<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.04.17
 * Time: 14:30
 */

namespace app\entities\Employee;


use app\repositories\InstantiateTrait;
use Assert\Assertion;
use yii\db\ActiveRecord;

class Status extends ActiveRecord
{
    use InstantiateTrait;
    const ACTIVE   = 'active';
    const ARCHIVED = 'archived';

    private $value;
    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * Status constructor.
     * @param $value
     * @param \DateTimeImmutable $date
     */
    public function __construct($value, \DateTimeImmutable $date)
    {
        Assertion::inArray($value, [
            self::ACTIVE,
            self::ARCHIVED,
        ]);

        $this->value = $value;
        $this->date = $date;
    }

    public function isActive()
    {
        return $this->value === self::ACTIVE;
    }

    public function isArchived()
    {
        return $this->value === self::ARCHIVED;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate() : \DateTimeImmutable
    {
        return $this->date;
    }

    ############INFRASTRUCTURE#########
    public static function tableName()
    {
        return '{{$ar_status}}';
    }

    public function afterFind()
    {
        $this->value = $this->getAttribute('status_value');
        $this->date = new \DateTimeImmutable($this->getAttribute('status_date'));

        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('status_value', $this->value);
        $this->setAttribute('status_date', $this->date->format('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
    }


}