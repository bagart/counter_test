<?php

use Illuminate\Database\Seeder;

class CountersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('counters')->insert([
            'counter' => 50000,
            'date' => '2017-07-01',
            'event_id' => 1,
            'country_id' => 1
        ]);

        DB::table('counters')->insert([
            'counter' => 100,
            'date' => '2017-07-01',
            'event_id' => 2,
            'country_id' => 1
        ]);

        DB::table('counters')->insert([
            'counter' => 3000,
            'date' => '2017-07-02',
            'event_id' => 1,
            'country_id' => 1
        ]);

        DB::table('counters')->insert([
            'counter' => 123,
            'date' => '2017-07-02',
            'event_id' => 3,
            'country_id' => 2
        ]);
    }
}
