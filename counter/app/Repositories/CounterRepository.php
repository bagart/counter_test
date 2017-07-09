<?php

namespace App\Repositories;


use App\Models\Counter;
use App\Models\Country;
use App\Models\Event;

class CounterRepository
{
    protected $target = Counter::class;
    protected $slot = 50;

    /**
     * @return Counter;
     */
    protected function getModel()
    {
        return App($this->target);
    }

    public function current($country, $event, $date = null)
    {
        if (is_string($country) && mb_strlen($country)) {
            $country = (new CountryRepository())
                ->getOrCreateByName($country);
        } elseif (!$country instanceof Country) {
            throw new \InvalidArgumentException('invalid params country:' . $country);
        }

        if (is_string($event) && mb_strlen($event)) {
            $event = (new EventRepository())
                ->getByName($event);
        } elseif (!$event instanceof Event) {
            throw new \InvalidArgumentException('invalid params event:' . $event);
        }

        $date = $date ?? date('Y-m-d');

        $result = $this->getModel()
            ->where('country_id', $country->id)
            ->where('event_id', $event->id)
            ->where('date', $date)
            ->select(\DB::raw('SUM(counter) as counter'))
            ->first();
        return $result->counter ?? 0;

    }

    public function inc($country, $event, $step = 1)
    {
        if (is_string($country) && mb_strlen($country)) {
            $country = (new CountryRepository())
                ->getOrCreateByName($country);
        } elseif (!$country instanceof Country) {
            throw new \InvalidArgumentException('invalid params country:' . $country);
        }

        if (is_string($event) && mb_strlen($event)) {
            $event = (new EventRepository())
                ->getByName($event);
        } elseif (!$event instanceof Event) {
            throw new \InvalidArgumentException('invalid params event:' . $event);
        }

        $date = date('Y-m-d');

        \DB::insert(
            "
              INSERT INTO `{$this->getModel()->getTable()}`
                (event_id, country_id, `date`, slot, counter)
              VALUES 
               (:event_id, :country_id, :date, rand() * :slot, :step1)
              ON DUPLICATE KEY UPDATE counter=counter + :step2
            ",
            [
                'event_id' => $event->id,
                'country_id' => $country->id,
                'date' => $date,
                'step1' => $step,
                'step2' => $step,
                'slot' => $this->slot,
            ]
        );

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
            HAVING sum(counter) > 0
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