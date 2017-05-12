<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 14:11
 */

namespace app\entities\Employee;


use Assert\Assertion;

class Phone
{
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


}