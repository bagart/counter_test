<?php

use \App\Repositories\EventRepository;
use App\Models\Event;

class EventRepositoryTest extends TestCase
{
    /**
     * @var EventRepository
     */
    protected $repository;
    /**
     * @var Event
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->repository = App(EventRepository::class);
        $this->model = App(Event::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetLastTopEventSumByCountry()
    {
        $this->assertEquals(1, $this->repository->getIdByName('view'));
        $this->assertEquals(2, $this->repository->getIdByName('play'));
        $this->assertEquals(3, $this->repository->getIdByName('click'));

        foreach ($this->model->all() as $element) {
            $this->assertEquals($element->id, $this->repository->getIdByName($element->name));
        }
    }
    public function testExceptionGetLastTopEventSumByCountry()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->repository->getIdByName('any not exists');
    }
}