<?php

use App\Models\Event;

class EventModelTest extends TestCase
{
    /**
     * @var Event
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->model = App(Event::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllIdByName()
    {
        $map = $this->model->getAllIdByName();
        $this->assertTrue(is_array($this->model->getAllIdByName()));

        foreach ($this->model->getAllIdByName() as $name => $id) {
            $this->assertGreaterThan(0, mb_strlen($name));
            $this->assertTrue(is_int($id));
        }

        $this->assertArrayHasKey('view', $map);
        $this->assertArrayHasKey('play', $map);
        $this->assertArrayHasKey('click', $map);
        $this->assertEquals(1, $map['view']);
        $this->assertEquals(2, $map['play']);
        $this->assertEquals(3, $map['click']);

        foreach ($this->model->all() as $element) {
            $this->assertArrayHasKey($element->name, $map);
            $this->assertEquals($element->id, $map[$element->name]);
        }
    }
}