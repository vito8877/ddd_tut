<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.04.17
 * Time: 13:38
 */

namespace app\entities;

use Assert\Assertion;

class Id
{
    protected $id;

    public function __construct($id = null)
    {
        Assertion::notEmpty($id);

        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isEqualTo(self $other)
    {
        return $this->getId() === $other->getId();
    }
}