<?php

namespace App\Repositories;

use App\Models\Counter;
use Illuminate\Database\QueryException;

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

    public function inc($country, $event, $step = 1)
    {
        if (
            !is_string($country)
            || !mb_strlen($country)
            || !is_string($event)
            || !mb_strlen($event)
        ) {
            throw new \InvalidArgumentException('invalid params');
        }
        $event_id = (new EventRepository())
            ->getIdByName($event);
        $country_id = (new CountryRepository())
            ->getOrCreateIdByName($country);
        $date = date('Y-m-d');

        try {
            $this->getModel()
                ->create([
                    'event_id' => $event_id,
                    'country_id' => $country_id,
                    'date' => $date,
                ]);
        } catch (QueryException $e) {
            if (23000 != $e->getCode()) {
                throw $e;
            }
        }

        \DB::table($this->getModel()->getTable())
            ->where('event_id', $event_id)
            ->where('country_id', $country_id)
            ->where('date', $date)
            ->increment('counter', $step);

        return true;
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