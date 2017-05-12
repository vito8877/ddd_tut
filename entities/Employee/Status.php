<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.04.17
 * Time: 14:30
 */

namespace app\entities\Employee;


use Assert\Assertion;
use yii\db\ActiveRecord;

class Status extends ActiveRecord
{
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
}