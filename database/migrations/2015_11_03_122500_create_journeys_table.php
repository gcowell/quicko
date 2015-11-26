<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journeys', function(Blueprint $table)
        {

            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('startaddress');
            $table->string('endaddress');
            $table->date('traveldate');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
        DB::statement('ALTER TABLE journeys ADD COLUMN startpoint POINT NOT NULL');
        DB::statement('ALTER TABLE journeys ADD COLUMN endpoint POINT NOT NULL');
        DB::statement('CREATE SPATIAL INDEX sx_start ON journeys(startpoint)');
        DB::statement('CREATE SPATIAL INDEX sx_end ON journeys(endpoint)');

        //NO_ZERO_DATE in MySQL my.ini must be enables

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('journeys');
    }
}
