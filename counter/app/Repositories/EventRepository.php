<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    protected $target = Event::class;

    public function getByName($name)
    {
        $event = new Event();
        $event->name = $name;
        $event->id = $this->getIdByName($name);

        return $event;
    }
    public function getIdByName($name)
    {
        $map = App($this->target)
            ->getAllIdByName();

        if (
            !$name
            || !is_string($name)
            || empty($map[$name])
        ) {
            throw new \InvalidArgumentException('Invalid name:'. $name);
        }

        return $map[$name];
    }
}