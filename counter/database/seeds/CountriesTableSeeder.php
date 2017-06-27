<?php

use Illuminate\Database\Seeder;
use App\Models\Country;
class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Country)->updateOrCreate([
            'id' => 1,
            'name' => 'Us',
        ]);

        (new Country)->updateOrCreate([
            'id' => 2,
            'name' => 'CA',
        ]);

        (new Country)->updateOrCreate([
            'id' => 3,
            'name' => 'Ru',
        ]);

    }
}
