<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository
{
    protected $target = Country::class;


    public function getOrCreateByName($name)
    {
        if (
            !$name
            || !is_string($name)
            || !mb_strlen($name)
        ) {
            throw new \InvalidArgumentException('name');
        }

        $country = App($this->target)
            ->updateOrCreate([
                'name' => $name,
            ]);

        return $country;
    }

    public function getOrCreateIdByName($name)
    {

        return $this->getOrCreateByName($name)->id;
    }
}