<?php

use Illuminate\Database\Seeder;
use App\Models\Event;
class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Event)->updateOrCreate([
            'id' => 1,
            'name' => 'view',
        ]);


        (new Event)->updateOrCreate([
            'id' => 2,
            'name' => 'play',
        ]);

        (new Event)->updateOrCreate([
            'id' => 3,
            'name' => 'click',
        ]);
    }
}
