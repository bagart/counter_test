<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'id' => 1,
            'name' => 'Us',
        ]);

        DB::table('countries')->insert([
            'id' => 2,
            'name' => 'CA',
        ]);

        DB::table('countries')->insert([
            'id' => 3,
            'name' => 'Ru',
        ]);

    }
}
