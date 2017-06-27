<?php
use App\Repositories\CounterRepository;
use App\Models\Counter;

class CounterRepositoryTest extends TestCase
{
    /**
     * @var CounterRepository
     */
    protected $counterRepository;
    /**
     * @var Counter
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->counterRepository = App(CounterRepository::class);
        $this->model = App(Counter::class);
    }

    public function testIncDec()
    {
        $counter = null;
        try {
            $counter = $this->model
                ->create([
                    'event_id' => 1,
                    'country_id' => 1,
                    'date' => date('Y-m-d'),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if (23000 != $e->getCode()) {
                throw $e;
            }
            $counter = $this->model
                ->where('event_id', 1)
                ->where('country_id', 1)
                ->where('date', date('Y-m-d'))
                ->first();
        }

        $this->counterRepository->inc(
            $counter->country()->first()->name,
            $counter->event()->first()->name,
            1
        );
        $this->assertEquals(
            $counter->counter + 1,
            $this->model->find($counter->id)->counter
        );

        $this->counterRepository->inc(
            $counter->country()->first()->name,
            $counter->event()->first()->name,
            5
        );
        $this->assertEquals(
            $counter->counter + 1 + 5,
            $this->model->find($counter->id)->counter
        );

        $this->counterRepository->inc(
            $counter->country()->first()->name,
            $counter->event()->first()->name,
            -1 - 5
        );
        $this->assertEquals(
            $counter->counter,
            $this->model->find($counter->id)->counter
        );
    }

    public function testGetLastTopEventSumByCountry()
    {
        $check = [];
        $checkCountries = [];
        $stats = $this->counterRepository
            ->getLastTopEventSumByCountry(
                '2 days',
                2
            );
        $this->assertGreaterThan(0, $stats);
        foreach ($stats as $stat) {
            $checkKey = $stat->event . '_' . $stat->country;
            $this->assertArrayNotHasKey($checkKey, $check);
            $check[$checkKey] = true;
            $checkCountries[$stat->country] = 1;

            //@todo check sql
        }
        $this->assertLessThanOrEqual(2, count($checkCountries));
    }
}