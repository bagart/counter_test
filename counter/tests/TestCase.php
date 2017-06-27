<?php
abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function getNewCountryName()
    {
        $i = 0;
        $notExistsCountry = null;
        while (!$notExistsCountry && $i++ < 10) {
            $notExistsCountry = 'not_exist_val_' . Faker\Factory::create()->numberBetween();
            $element = (new \App\Models\Country())->where('name', $notExistsCountry)->first();
            if ($element) {
                $notExistsCountry = null;
            }
        }
        if (!$notExistsCountry) {
            $this->assertTrue(false, 'test internal error');
            return;
        }

        return $notExistsCountry;
    }
}