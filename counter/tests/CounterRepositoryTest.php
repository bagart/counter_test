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