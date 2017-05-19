<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 18.05.17
 * Time: 21:46
 */

namespace app\repositories;


trait InstantiateTrait
{
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