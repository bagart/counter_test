<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'id' => 1,
            'name' => 'view',
        ]);

        DB::table('events')->insert([
            'id' => 2,
            'name' => 'play',
        ]);

        DB::table('events')->insert([
            'id' => 3,
            'name' => 'click',
        ]);
    }
}
