<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
class ControllerCounterIncTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNewCountry()
    {
        $this->json('POST', '/counter', [
            'country' => Faker\Factory::create()->countryCode . '_' . Faker\Factory::create()->randomDigitNotNull,
            'event' => 'plays',
        ]);
        dd($this->response->getContent());
        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}