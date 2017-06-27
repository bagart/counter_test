<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Repositories\CounterRepository;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class CounterController extends Controller
{
    public function get(Request $request)
    {
        $format = $request->get('format') ?? 'json';
        dd($format);
        $result = (new CounterRepository)->getLastTopEventSumByCountry();
        //@todo output format
        return $result;
    }

    public function inc(Request $request)
    {
        if (
            !is_string($request->get('event'))
            || !mb_strlen($request->get('event'))
            || !is_string($request->get('country'))
            || !mb_strlen($request->get('country'))
        ) {
            throw new \HttpRequestException('invalid params');
        }
        $event_id = (new Event)
            ->getIdByName($request->get('event'));

        $country_id = CountryRepository::getOrCreateIdByName($request->get('country'));
        return $request->toArray();
    }
}
