<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    protected $target = Event::class;

    public function getIdByName($name)
    {
        $map = App($this->target)->getAllIdByName();
        if (
            !$name
            || !is_string($name)
            || empty($map[$name])
        ) {
            throw new \InvalidArgumentException('name');
        }

        return $map[$name];
    }
}