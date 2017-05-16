<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 11:36
 */

namespace app\dispatchers;


class DummyEventDispatcher implements EventDispatcher
{
    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            \Yii::info('Dispatch event ' . get_class($event));
        }
    }
}