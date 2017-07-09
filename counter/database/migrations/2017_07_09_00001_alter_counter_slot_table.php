<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCounterSlotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->tinyInteger('slot')->unsigned();
            $table->dropUnique(['country_id', 'event_id', 'date']);
            $table->unique(['country_id', 'event_id', 'date','slot']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('counters');
    }
}
