<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 11:33
 */

namespace app\dispatchers;


interface EventDispatcher
{
    public function dispatch(array $events);
}