<?php

namespace App\Repositories;

use App\Models\Counter;

class CounterRepository
{
    protected $target = Counter::class;

    /**
     * @return Counter;
     */
    protected function getModel()
    {
        return App($this->target);
    }

    public function getLastTopEventSumByCountry(
        $period = '7 days',
        $countryLimit = 5
    ) {
        return \DB::select('
            SELECT
              countries.name country,
              events.name event,
              sum(counter) counter
            FROM counters
              JOIN (
                  SELECT country_id
                     FROM counters
                     WHERE DATE BETWEEN :date_from_country AND :date_to_country
                     GROUP BY country_id
                     ORDER BY sum(counter) DESC
                     LIMIT :limit_country
                   ) AS top_country ON counters.country_id = top_country.country_id
              JOIN countries ON countries.id = counters.country_id
              JOIN events ON events.id = counters.event_id
            WHERE DATE BETWEEN :date_from AND :date_to
            GROUP BY countries.name, events.name
            ORDER BY sum(counter) DESC
            ',
            [
                'date_from_country' => date('Y-m-d', strtotime('now - ' . $period)),
                'date_to_country' => date('Y-m-d', strtotime('tomorrow')),
                'date_from' => date('Y-m-d', strtotime('now - ' . $period)),
                'date_to' => date('Y-m-d', strtotime('tomorrow')),
                'limit_country' => $countryLimit
            ]
        );

    }
}