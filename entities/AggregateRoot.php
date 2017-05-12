<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 21:54
 */

namespace app\entities;


interface AggregateRoot
{
    public function getId();

    public function releaseEvents();
}