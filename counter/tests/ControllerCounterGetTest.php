<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
class ControllerCounterGetTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetJson()
    {
        $this->get('/counter?format=json');
        dd($this->response->getContent());
        $this->assertEquals(
            $this->app->version(),
            $this->response->getContent()
        );
    }

    public function testGetCsv()
    {
        //@todo
        $this->get('/counter?format=csv');
    }
}