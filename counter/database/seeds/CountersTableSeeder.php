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
        try {
            DB::table('counters')->insert([
                'counter' => 50000,
                'date' => date('Y-m-d', strtotime('-1 day')),
                'event_id' => 1,
                'country_id' => 1
            ]);

            DB::table('counters')->insert([
                'counter' => 100,
                'date' => date('Y-m-d', strtotime('-1 day')),
                'event_id' => 2,
                'country_id' => 1
            ]);

            DB::table('counters')->insert([
                'counter' => 3000,
                'date' => date('Y-m-d'),
                'event_id' => 1,
                'country_id' => 1
            ]);

            DB::table('counters')->insert([
                'counter' => 123,
                'date' => date('Y-m-d'),
                'event_id' => 3,
                'country_id' => 2
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() != 23000) {
                throw $e;
            }

        }
    }
}
