<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 14:11
 */

namespace app\entities\Employee;


use app\repositories\InstantiateTrait;
use Assert\Assertion;
use yii\db\ActiveRecord;

class Phone extends ActiveRecord
{
    use InstantiateTrait;

    private $country;
    private $code;
    private $number;

    public function __construct($country, $code, $number)
    {
        Assertion::notEmpty($country);
        Assertion::notEmpty($code);
        Assertion::notEmpty($number);

        $this->country = $country;
        $this->code = $code;
        $this->number = $number;
    }

    public function isEqualTo(self $phone)
    {
        return $this->getFull() === $phone->getFull();
    }

    public function getFull()
    {
        return '+' . $this->country . ' (' . $this->code . ') ' . $this->number;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

############INFRASTRUCTURE#########
    public static function tableName()
    {
        return '{{$ar_phone}}';
    }

    public function afterFind()
    {
        $this->country = $this->getAttribute('phone_country');
        $this->code = $this->getAttribute('phone_code');
        $this->number = $this->getAttribute('phone_number');

        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('phone_country', $this->country);
        $this->setAttribute('phone_code', $this->code);
        $this->setAttribute('phone_number', $this->number);

        return parent::beforeSave($insert);
    }


}