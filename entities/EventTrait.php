<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 15.04.17
 * Time: 22:01
 */

namespace app\entities;


trait EventTrait
{
    private $events = [];

    protected function recordEvent($event)
    {
        $this->events[] = $event;
    }

    public function releaseEvents() : array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}