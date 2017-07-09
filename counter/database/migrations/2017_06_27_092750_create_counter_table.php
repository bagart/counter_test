<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('counter')->default(0);
            $date = $table->date('date');

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events');

            $table->unique(['country_id', 'event_id', 'date']);
            //$table->index(['country_id', 'date']);

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
