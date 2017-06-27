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

    public function testExistsCountry()
    {
        $date = date('Y-m-d');
        $counters = Counter::where('date', $date)->get();

        foreach ($counters as $counter) {
            $country = $counter->country()->first();
            $event = $counter->event()->first();

            $this->json(
                'POST',
                '/counter',
                [
                    'country' => $country->name,
                    'event' => $event->name,
                ]
            );
            $this->checkResponse();

            $counterTest = Counter::where('event_id', $event->id)
                ->where('country_id', $country->id)
                ->where('date', $date)
                ->first();

            $this->assertEquals($counterTest->counter, $counter->counter + 1);

            (new CounterRepository)->inc(
                $country->name,
                $event->name,
                -1
            );

            $counterTest = Counter::where('event_id', $event->id)
                ->where('country_id', $country->id)
                ->where('date', $date)
                ->first();

            $this->assertEquals($counterTest->counter, $counter->counter);
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
        $this->assertEmpty( Counter::where('event_id', $event->id)
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