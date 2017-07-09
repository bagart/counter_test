<?php
use App\Repositories\CounterRepository;
use App\Models\Counter;
use App\Models\Event;
use App\Models\Country;

class ControllerCounterIncTest extends TestCase
{
    protected function checkResponse()
    {
        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('application/json', $this->response->headers->get('content-type'));
        $json = json_decode($this->response->getContent(), true);
        $this->assertNotEmpty($json);
        $this->assertArrayHasKey('result', $json);
    }

    public function testAll()
    {
        $date = date('Y-m-d');
        $countries = Country::all();
        $events = Event::all();

        foreach ($countries as $country) {
            foreach ($events as $event) {
                $initVal = (new CounterRepository)
                    ->current($country->name, $event->name, $date);

                (new CounterRepository)->inc(
                    $country->name,
                    $event->name
                );

                $incVal = (new CounterRepository)
                    ->current($country->name, $event->name, $date);
                $this->assertEquals($initVal + 1, $incVal);

                $this->json(
                    'POST',
                    '/counter',
                    [
                        'country' => $country->name,
                        'event' => $event->name,
                    ]
                );

                $callVal = (new CounterRepository)
                    ->current($country->name, $event->name, $date);
                $this->checkResponse();
                $this->assertEquals($initVal + 2, $callVal);

                (new CounterRepository)->inc(
                    $country->name,
                    $event->name,
                    -2
                );

                $decVal = (new CounterRepository)
                    ->current($country->name, $event->name, $date);
                $this->assertEquals($initVal, $decVal);
            }
        }
    }

    public function testNewCountry()
    {
        $notExistsCountry = $this->getNewCountryName();

        if (!$notExistsCountry) {
            return;
        }

        $this->json(
            'POST',
            '/counter',
            [
                'country' => $notExistsCountry,
                'event' => 'play',
            ]
        );

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('application/json', $this->response->headers->get('content-type'));
        $json = json_decode($this->response->getContent(), true);
        $this->assertNotEmpty($json);
        $this->assertArrayHasKey('result', $json);
        $country = Country::where('name', $notExistsCountry)->first();
        $event = Event::where('name', 'play')->first();

        $counter = Counter::where('event_id', $event->id)
            ->where('country_id', $country->id)
            ->where('date', date('Y-m-d'))
            ->first();
        $this->assertEquals(1, $counter->counter);
        $counter->delete();
        $country->delete();
        $this->assertEmpty(Counter::where('event_id', $event->id)
            ->where('country_id', $country->id)
            ->where('date', date('Y-m-d'))
            ->first());
    }

    public function testNewEvent()
    {
        $this->json(
            'POST',
            '/counter',
            [
                'country' => 'Us',
                'event' => 'not exists event',
            ]
        );
        $this->assertEquals(500, $this->response->getStatusCode());
    }
}