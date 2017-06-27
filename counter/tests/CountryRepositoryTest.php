<?php

use \App\Repositories\CountryRepository;
use App\Models\Country;

class CountryRepositoryTest extends TestCase
{
    /**
     * @var CountryRepository
     */
    protected $repository;
    /**
     * @var Country
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->repository = App(CountryRepository::class);
        $this->model = App(Country::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExistsGetOrCreateIdByName()
    {
        foreach ($this->model->all() as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals(
                $country->id,
                $this->repository->getOrCreateByName($country->name)->id
            );
            $this->assertEquals(
                $country->id,
                $this->repository->getOrCreateIdByName($country->name)
            );
        }
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNotExistsGetOrCreateIdByName()
    {
        $notExistsCountry = $this->getNewCountryName();
        if (!$notExistsCountry) {
            return;
        }

        $id = $this->repository->getOrCreateIdByName($notExistsCountry);
        $country = $this->repository->getOrCreateByName($notExistsCountry);
        $this->assertInstanceOf(Country::class, $country);
        $this->assertEquals($id, $country->id);
        $this->assertEquals($id, $this->repository->getOrCreateByName($notExistsCountry)->id);

        $country = $this->model->where('name', $notExistsCountry)->first();
        $this->assertInstanceOf(Country::class, $country);
        $this->assertEquals($country->id, $id);
        $country->delete();
        $this->assertNull($this->model->where('name', $notExistsCountry)->first());
    }
}