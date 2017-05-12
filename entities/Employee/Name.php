<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 14:11
 */

namespace app\entities\Employee;


use Assert\Assertion;

class Name
{

    private $last;
    private $first;
    private $middle;

    public function __construct($last, $first, $middle)
    {
        Assertion::notEmpty($last);
        Assertion::notEmpty($first);

        $this->last = $last;
        $this->first = $first;
        $this->middle = $middle;
    }

    public function getFull()
    {
        return trim($this->last . ' ' . $this->first . ' ' . $this->middle);
    }

    /**
     * @return mixed
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * @return mixed
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @return mixed
     */
    public function getMiddle()
    {
        return $this->middle;
    }
}